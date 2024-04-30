@extends('layouts.theme.master')

@section('content')
	<main>
		<section class="match-banner">
			<img class="match-banner-img" src="{{ asset('themeAssets/images/hero-banner.jpg') }}" alt="">
		</section>
		<section class="chat-main common-padding common-bg-pattern">
            @if(isset($interested_list) && count($interested_list) > 0)
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12 col-lg-4" style="overflow: hidden;">
                            <div class="chat-box" id="interested-list" style="overflow-y: hidden;">
                                <ul style="overflow-y: auto; width: calc(100%); scrollbar-width: none; -ms-overflow-style: none;">
                                    @foreach ($interested_list as $id => $value)
                                        <li data-user-id="{{ $value['id'] }}" class="interested-user">
                                            <a class="selected" href="#" data-user-id="{{ $value['id'] }}">
                                                <img class="chat-user-img" src="@if(Auth::user()->profile_image) {{ asset(''. $value['profile_image'])}} @else {{ asset('themeAssets/images/match-one.jpg') }} @endif" alt="" style="width: 80px; height: 80px; object-fit: cover;">
                                                <div class="chatlist-info">
                                                    <div class="name-time">
                                                        <h4>
                                                            {{ $value['name'] ? (strlen($value['name']) > 13 ? substr($value['name'], 0, 13) . '...' : $value['name']) : "" }}
                                                        </h4>
                                                        <span>{{ $value['last_seen'] }}</span>
                                                    </div>
                                                    <div class="d-flex flex-row justify-content-between">
                                                        <p style="font-size: 15px">
                                                            {{ $value['last_message'] ? (strlen($value['last_message']) > 20 ? substr($value['last_message'], 0, 20) . '...' : $value['last_message']) : "" }}
                                                        </p>
                                                        @if($value['unseen_message'])<p id="data-unseen-id-{{ $value['id'] }}" class="unseen-message-badge badge badge-pill badge-primary" style="border-radius: 50%; padding: 2px 8px; color: white; background-color: rgb(139, 19, 19);">{{ $value['unseen_message'] }}</span>@endif
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        {{-- chat content --}}
                        <div class="col-sm-12 col-lg-8">
                            <div class="chat-box chat-message-box" id="chat-box">
                                <div class="chat-main">
                                    <div class="chat-conversion"></div>
                                </div>
                                <div class="chat-footer">
                                    <form action="javascript:void(0);">
                                        <input type="text" placeholder="Type message" />
                                        <button><img class="send-icon" src="{{ asset('themeAssets/images/sent-mail.png') }}" alt=""></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
            <div class="d-flex justify-content-center">
                <p class=" text-center p-2 rounded" style="background-color: rgba(211, 211, 211, 1); color: black; width: 60%" >No Chat found.</p>
            </div>
            @endif
		</section>
	</main>
    <!-- /main -->
@endsection

@section('js')

<script>
    // Dictionary to store the last displayed date for each user
    let lastDisplayedDates = {};

    document.addEventListener('DOMContentLoaded', function() {
        // Add click event listeners to interested users
        const interestedUsers = document.querySelectorAll('.interested-user');
        interestedUsers.forEach((user, index) => {
            user.addEventListener('click', function(e) {
                e.preventDefault();
                const userId = this.getAttribute('data-user-id');
                console.log('Selected user ID:', userId);

                // Reset the lastDisplayedDates dictionary when clicking on a different user
                lastDisplayedDates = {};

                // Log the constructed URL
                const url = `http://127.0.0.1:8000/chat-user-data/${userId}`;



                // Send fetch request to fetch chat data
                fetch(url)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        // Update the chat-box with the fetched data
                        const element = document.getElementById('data-unseen-id-'+ userId);
                if (element) {
                    element.style.display = 'none'; // Change 'propertyName' and 'newValue' to the desired CSS property and value
                }
                        updateChatBox(data);
                    })
                    .catch(error => {
                        // Handle error
                        // console.error('Error fetching chat data:', error);
                    });
            });
            // Trigger click event on the first interested user by default,
            // if (index === 0) {
            //     user.click();
            // }
        });
    });

    function updateChatBox(data) {
// location.reload();

        const chatBox = document.getElementById('chat-box');

        // Clear previous chat content
        chatBox.innerHTML = '';

        // Get the chat user data
        const chatUser = data.data.chat_user;

        // Generate the full URL to the profile image
        const profileImageUrl = '{{ asset('') }}' + chatUser.profile_image;

        // HTML for the chat header
        const liveAtTime = new Date(chatUser.live_at);
        const today = new Date();
        let liveAtDisplay = '';
        if (chatUser.live_at) {
            const liveAtTime = new Date(chatUser.live_at);
            const today = new Date();

            if (liveAtTime.toDateString() === today.toDateString()) {
                // If live_at is today, display only the time
                liveAtDisplay = 'last seen today at ' + liveAtTime.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
            } else {
                // If live_at is not today, display both date and time
                liveAtDisplay = 'last seen at '+ liveAtTime.toLocaleString();
            }
        }

        const headerHtml = `
            <div class="chat-header">
                <img class="chat-user-img" src="${profileImageUrl}" alt="" data-user-id="${chatUser.id}" style="width: 80px; height: 80px; object-fit: cover;">
                <div class="chat-message-info">
                    <div class="chat-message-name">
                        <h4>${chatUser.name}</h4>
                        <span>${liveAtDisplay}</span>
                    </div>
                    <div class="chat-message-request">
                        ${data.data.status_option.map(option => `
                            <a class="btn btn-custom ml-3" href="{{ url('/interest-status-change/${option.toLowerCase()}/${chatUser.id}') }}" data-status="${option.toLowerCase()}">${option === 'accept' ? 'Accept' : (option === 'reject' ? 'Reject' : (option === 'block' ? 'Block' : (option === 'unblock' ? 'Unblock' : option)))}</a>
                        `).join('')}
                    </div>
                </div>
            </div>
        `;

        // Append the HTML for the chat header to the chat box
        chatBox.innerHTML += headerHtml;

        // Append the conversation area
        const conversationHtml = `
            <div class="chat-conversion" style="height: 473px; overflow-y: auto; width: calc(100%); padding-top: 15px; scrollbar-width: none; -ms-overflow-style: none;">
        `;
        chatBox.innerHTML += conversationHtml;

        // Fetch and append existing messages
        fetchMessages(chatUser.id)
        .then(() => {
            // Append the footer for sending messages
            const footerHtml = `
                <div class="chat-footer mt-0">
                    <form id="message-form" action="javascript:void(0);">
                        @csrf
                        <input id="message-input" name="message-input" type="text" placeholder="Type message" />
                        <button><img class="send-icon" src="{{ asset('themeAssets/images/sent-mail.png') }}" alt=""></button>
                    </form>
                </div>
            `;
            chatBox.innerHTML += footerHtml;

            // Attach event listener to the form submission
            const messageForm = document.getElementById('message-form');
            messageForm.addEventListener('submit', function(event) {
                event.preventDefault(); // Prevent default form submission

                // Fetch the message content from the input field
                const messageInput = document.getElementById('message-input');
                const messageContent = messageInput.value.trim();

                // Clear the input field
                messageInput.value = '';

                // Generate a timestamp in the format expected by Laravel's Eloquent models
                const timestamp = new Date().toISOString().slice(0, 19).replace('T', ' ');

                // Pass the generated timestamp to the appendMessage function
                appendMessage(messageContent, timestamp, 'sent', chatUser.id);

                // Create FormData object to send form data
                const formData = new FormData();
                formData.append('friend_id', chatUser.id);
                formData.append('message', messageContent);

                // Send an AJAX request with the CSRF token included in the headers
                fetch('{{ route('send-message') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token // Include CSRF token from the JavaScript variable
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    // Handle the response data
                })
                .catch(error => {
                    // console.error('Error:', error);
                });
            });
        });
    }

    // Fetch previous messages for the specified user
    function fetchMessages(userId) {
        return fetch('{{ route('chat-list') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token
            },
            body: JSON.stringify({
                user_id: userId
            })
        })
        .then(response => response.json())
        .then(data => {
            // Append received messages to the chat box
            console.log(data);
            data.data.forEach(message => {
                appendMessage(message.message,message.timestamp,message.type, userId);
            });
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }

    // append all fetch message and new send message
    function appendMessage(message, timestamp, type, userId) {
        // Parse the timestamp string and create a Date object
        const dateTime = timestamp ? new Date(timestamp) : new Date();

        // Extract the date portion from the Date object
        const date = dateTime.toDateString();

        // Extract the time portion from the Date object and format it as desired
        const time = dateTime.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

        // Determine the class for message alignment
        const alignmentClass = type === 'receive' ? 'text-left ml-2 mr-1' : 'text-right mr-2 ml-1';

        // Determine if the message is from today, yesterday, or an earlier date
        let dateText = '';
        const today = new Date();
        const yesterday = new Date(today);
        yesterday.setDate(yesterday.getDate() - 1);
        if (dateTime.toDateString() === today.toDateString()) {
            dateText = 'Today';
        } else if (dateTime.toDateString() === yesterday.toDateString()) {
            dateText = 'Yesterday';
        } else {
            const year = dateTime.getFullYear();
            const month = String(dateTime.getMonth() + 1).padStart(2, '0'); // Add leading zero if needed
            const day = String(dateTime.getDate()).padStart(2, '0'); // Add leading zero if needed
            dateText = `${day}-${month}-${year}`;
        }

        // Check if the last displayed date for this user is different from the current message's date
        if (lastDisplayedDates[userId] !== date) {
            // If different, display the date along with the message
            const dateHtml = `<p class="mt-1 ml-2 text-center" style="font-size:px;">${dateText}</p>`;
            const chatMain = document.querySelector('.chat-conversion');
            chatMain.innerHTML += dateHtml;

            // Update the last displayed date for this user
            lastDisplayedDates[userId] = date;
        }

        // Generate the HTML for the message
        const messageHtml = `
            <div class="${alignmentClass}">
                <div class="message-container" style="width: 100%;">
                    <div class="message-common">
                        <span class="fs-3 rounded px-2 py-1 bg-opacity-10" style="background-color: rgba(211, 211, 211, 0.5); color: black; display: inline-block;">${message}</span>
                    </div>
                    <p class="mt-1 ml-2" style="font-size:10px;">${time}</p>
                </div>
            </div>
        `;

        // Append the message HTML to the chat box
        const chatMain = document.querySelector('.chat-conversion');
        chatMain.innerHTML += messageHtml;

        // Scroll to the bottom of the chat box
        chatMain.scrollTop = chatMain.scrollHeight;
    }

</script>

@endsection
