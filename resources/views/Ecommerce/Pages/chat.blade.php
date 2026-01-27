@extends('Ecommerce.Layout.index')
@section('container')
    <style>
        body {
            background: #eef2f7;
        }

        /* ================== CHAT LAYOUT ================== */
        .chat-container {
            height: 70vh;
            max-height: 70vh;
            display: flex;
            flex-direction: column;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        /* Chat header */
        .chat-header {
            background: #f18a03;
            color: #fff;
            padding: 12px 16px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 12px;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }

        .chat-header .avatar {
            width: 40px;
            height: 40px;
            background: #fff;
            color: #f58e07;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 50%;
            font-weight: bold;
        }

        /* Chat body */
        #chat-box {
            flex-grow: 1;
            padding: 16px;
            overflow-y: auto;
            background: #f4f7fb;
        }

        .chat-row {
            display: flex;
            margin-bottom: 12px;
        }

        .chat-row.me {
            justify-content: flex-end;
        }

        .chat-bubble {
            max-width: 70%;
            padding: 10px 14px;
            border-radius: 20px;
            font-size: 14px;
            line-height: 1.4;
            word-break: break-word;
        }

        .chat-bubble.me {
            background: #f58e07;
            color: #fff;
            border-bottom-right-radius: 6px;
        }

        .chat-bubble.admin {
            background: #e4e6eb;
            color: #333;
            border-bottom-left-radius: 6px;
        }

        /* Chat footer */
        .chat-footer {
            display: flex;
            padding: 12px 16px;
            gap: 8px;
            border-top: 1px solid #dee2e6;
            background: #fff;
            border-bottom-left-radius: 8px;
            border-bottom-right-radius: 8px;
        }

        .chat-footer input {
            flex-grow: 1;
            border-radius: 20px;
            padding: 10px 16px;
            border: 1px solid #ccc;
        }

        .chat-footer button {
            background: #f58e07;
            color: #fff;
            border: none;
            width: 42px;
            height: 42px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            cursor: pointer;
        }

        .chat-footer button:hover {
            background: #e07f05;
        }

        /* Scrollbar styling */
        #chat-box::-webkit-scrollbar {
            width: 6px;
        }

        #chat-box::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.2);
            border-radius: 3px;
        }

        /* Mobile adjustments */
        @media(max-width: 576px) {
            .chat-container {
                height: 60vh;
            }
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <section class="banner-area organic-breadcrumb">
        <div class="container">
            <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
                <div class="col-first">
                    <h1>Support</h1>
                    <nav class="d-flex align-items-center">
                        <a href="{{ route('HomePage') }}">Home<span class="lnr lnr-arrow-right"></span></a>
                        <a href="#">Chat</a>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <section class="checkout_area section_gap">
        <div class="container d-flex justify-content-center">
            <div class="chat-container w-100 w-md-75">

                <!-- Chat Header -->
                <div class="chat-header">
                    <div class="avatar">A</div>
                    <div>
                        <div>Karma Support</div>
                        <small>Online</small>
                    </div>
                </div>

                <!-- Chat Messages -->
                <div id="chat-box">
                    <!-- Messages will appear here -->
                </div>

                <!-- Chat Input -->
                <div class="chat-footer">
                    <input type="text" id="chat-message" placeholder="Type a message...">
                    <button id="send-chat" title="Send">
                        <i class="bi bi-send-fill"></i>
                    </button>

                </div>
            </div>
        </div>
    </section>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" crossorigin="anonymous"></script>

    <script>
        let chatBox = $('#chat-box');
        let userId = {{ auth()->id() }};

        function loadMessages() {
            $.get("{{ url('/user/chat/messages') }}", function(data) {
                chatBox.html('');
                data.forEach(msg => {
                    let isMe = msg.sender_id === userId;
                    let bubbleClass = isMe ? 'me' : 'admin';
                    chatBox.append(`
                    <div class="chat-row ${isMe ? 'me' : ''}">
                        <div class="chat-bubble ${bubbleClass}">${msg.message}</div>
                    </div>
                `);
                });
                chatBox.scrollTop(chatBox[0].scrollHeight);
            });
        }

        // Send message
        $('#send-chat').on('click', function() {
            let msg = $('#chat-message').val().trim();
            if (!msg) return;

            $.post("{{ url('/user/chat/send') }}", {
                _token: "{{ csrf_token() }}",
                message: msg
            }, function() {
                $('#chat-message').val('');
                loadMessages();
            });
        });

        // Load messages every 3 seconds
        setInterval(loadMessages, 3000);

        // Initial load
        loadMessages();
    </script>
@endsection
