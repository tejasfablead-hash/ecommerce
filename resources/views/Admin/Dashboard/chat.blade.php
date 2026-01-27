@extends('Admin.Pages.index')

@section('container')
    <style>
        body {
            background: #eef2f7;
        }

        /* ========== LEFT CHAT LIST ========== */
        .chat-user {
            cursor: pointer;
            border: none;
            transition: 0.2s;
        }

        .chat-user:hover {
            background: #eef4ff;
        }

        .chat-user.active {
            background: #e9f0ff;
            border-left: 4px solid #4f6df5;
        }

        .avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: #4f6df5;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 16px;
        }

        /* ========== CHAT AREA ========== */
        #chat-box {
            background: #f4f7fb;
        }

        .chat-row {
            display: flex;
            align-items: flex-end;
            margin-bottom: 14px;
        }

        .chat-row.me {
            justify-content: flex-end;
        }

        .chat-bubble {
            max-width: 65%;
            padding: 10px 14px;
            border-radius: 18px;
            font-size: 14px;
            line-height: 1.4;
            position: relative;
            word-break: break-word;
        }

        .chat-bubble.me {
            background: #4f6df5;
            color: #fff;
            border-bottom-right-radius: 6px;
        }

        .chat-bubble.other {
            background: #ffffff;
            color: #333;
            border-bottom-left-radius: 6px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }

        /* three dots */
        .msg-actions {
            position: absolute;
            top: 12px;
            right: -12px;
            display: none;
            z-index: 10;
            color: black
        }

        .chat-bubble.me:hover .msg-actions {
            display: block;
        }

        .msg-actions i {
            font-size: 14px;
            cursor: pointer;
            opacity: 0.8;
        }

        .msg-actions i:hover {
            opacity: 1;
        }


        /* ========== INPUT ========== */
        .chat-input {
            border-radius: 30px;
            padding: 10px 16px;
        }

        /* ========== RIGHT PROFILE PANEL ========== */
        .profile-panel {
            background: #fff;
            border-left: 1px solid #dee2e6;
            height: 100%;
        }

        .profile-panel img {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            object-fit: cover;
        }

        .profile-item {
            font-size: 14px;
            margin-bottom: 10px;
        }

        /* Ensure middle chat column layout */
        .chat-middle {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        /* Only messages scroll */
        #chat-box {
            flex-grow: 1;
            overflow-y: auto;
            padding-bottom: 10px;
        }

        /* Fix input at bottom */
        .chat-footer {
            position: sticky;
            bottom: 0;
            background: #fff;
            z-index: 20;
            border-top: 1px solid #dee2e6;
        }

        /* Round send button perfectly */
        #send-chat {
            width: 42px;
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>

    <div class="nxl-container">
        <div class="nxl-content">
            <div class="main-content">
                <div class="row" style="height:80vh;">

                    <!-- ================= LEFT CHAT LIST ================= -->
                    <div class="col-md-4 p-0 bg-white border-end d-flex flex-column">
                        <div class="p-3 border-bottom fw-bold d-flex justify-content-between align-items-center">
                            <span>Messages</span>

                        </div>

                        <div class="flex-grow-1 overflow-auto">
                            <ul class="list-group list-group-flush" id="chat-users">
                                @foreach ($chats as $user)
                                    @php
                                        $unread = $user
                                            ->sentMessages()
                                            ->where('receiver_id', auth()->id())
                                            ->where('is_seen', 0)
                                            ->count();

                                        $lastMessage = $user->sentMessages()->latest()->first()?->message;
                                    @endphp

                                    <li class="list-group-item chat-user d-flex align-items-center px-3 py-2"
                                        data-id="{{ $user->id }}">

                                        <div class="me-3">
                                            <div class="avatar">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                        </div>

                                        <div class="flex-grow-1 overflow-hidden">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <strong class="text-truncate text-capitalize" style="color: black">
                                                    {{ $user->name }}
                                                </strong>

                                                @if ($unread)
                                                    <span class="badge bg-primary rounded-pill unread-count">
                                                        {{ $unread }}
                                                    </span>
                                                @endif
                                            </div>

                                            <small class="text-muted text-truncate d-block">
                                                {{ $lastMessage ?? 'No messages yet' }}
                                            </small>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <!-- ================= MIDDLE CHAT ================= -->
                    <div class="col-md-8 p-0 bg-white chat-middle">

                        <div class="border-bottom p-3 d-flex align-items-center gap-2">
                            <div class="avatar" id="chat-avatar">U</div>
                            <div>
                                <h6 id="chat-title" class="mb-0 text-capitalize">Select a chat</h6>
                                <small class="text-success">Online</small>
                            </div>
                        </div>

                        <div class="flex-grow-1 p-4 overflow-auto" id="chat-box"></div>
                        <div class="chat-footer p-3">
                            <div class="d-flex gap-2">
                                <input type="text" id="chat-message" class="form-control chat-input"
                                    placeholder="Type a message...">
                                <button class="btn btn-primary rounded-circle" id="send-chat">
                                    <i class="bi bi-send"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- ================= RIGHT PROFILE ================= -->
                    {{-- <div class="col-md-3 profile-panel p-3">
                    <div class="text-center mb-3">
                        <img src="https://i.pravatar.cc/15" alt="profile">
                        <h6 class="mt-2 mb-0" id="profile-name">User Name</h6>
                        <small class="text-success">Available</small>
                    </div>

                    <hr>

                    <div class="profile-item"><strong>Email:</strong> user@email.com</div>
                    <div class="profile-item"><strong>Phone:</strong> +91 99999 99999</div>
                    <div class="profile-item"><strong>Joined:</strong> 17 Jul 2022</div>
                </div> --}}

                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        let activeChat = null;
        let isEditing = false;
        let editingMessageId = null;

        $(document).on('click', '.chat-user', function() {
            activeChat = $(this).data('id');

            $('.chat-user').removeClass('active');
            $(this).addClass('active');

            $('#chat-title').text($(this).find('strong').text());
            $('#chat-avatar').text($(this).find('.avatar').text());
            $('#profile-name').text($(this).find('strong').text());

            loadMessages();
        });

        $('#send-chat').on('click', function() {
            let msg = $('#chat-message').val().trim();
            if (!msg || !activeChat) return;

            if (isEditing) {
                $.post("{{ route('AdminchatUpdate') }}", {
                    id: editingMessageId,
                    message: msg,
                    _token: "{{ csrf_token() }}"
                }, () => {
                    resetEdit();
                    loadMessages();
                });
                return;
            }

            $.post("{{ route('AdminchatSend') }}", {
                user_id: activeChat,
                message: msg,
                _token: "{{ csrf_token() }}"
            }, () => {
                $('#chat-message').val('');
                loadMessages();
            });
        });

        function resetEdit() {
            isEditing = false;
            editingMessageId = null;
            $('#chat-message').val('');
        }

        let chatUrlTemplate = "{{ route('AdminchatShow', ['chatId' => ':id']) }}";

        function loadMessages() {
            if (!activeChat) return;
            let url = chatUrlTemplate.replace(':id', activeChat);

            $.get(url, function(res) {
                $('#chat-box').html('');
                res.forEach(m => {
                    let isMe = m.sender_id === {{ auth()->id() }};
                    $('#chat-box').append(`
    <div class="chat-row ${isMe ? 'me' : ''}">
        <div class="chat-bubble ${isMe ? 'me' : 'other'} chat-msg" data-id="${m.id}">
            <span class="chat-text">${m.message}</span>

            ${isMe ? `
                                    <div class="msg-actions dropdown">
                                        <span data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </span>
                                        <ul class="dropdown-menu dropdown-menu-end shadow">
                                            <li>
                                                <a class="dropdown-item edit-msg" href="javascript:void(0)">
                                                    <i class="bi bi-pencil me-2"></i>Edit
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item text-danger delete-msg" href="javascript:void(0)">
                                                    <i class="bi bi-trash me-2"></i>Delete
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                ` : ''}
        </div>
    </div>
`);

                });

                $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight);
            });
        }

        setInterval(() => {
            if (activeChat && !isEditing) loadMessages();
        }, 3000);

        $(document).on('click', '.edit-msg', function(e) {
            e.preventDefault();
            e.stopPropagation();

            let box = $(this).closest('.chat-msg');
            editingMessageId = box.data('id');

            let text = box.find('.chat-text').text().trim();
            $('#chat-message').val(text).focus();

            isEditing = true;
        });

        $(document).on('click', '.delete-msg', function(e) {
            e.preventDefault();
            e.stopPropagation();
            let url = "{{ route('AdminchatDelete') }}";
            let msgId = $(this).closest('.chat-msg').data('id');

            Swal.fire({
                title: 'Delete message?',
                text: 'This cannot be undone',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Delete'
            }).then((result) => {

                if (result.value == true) {
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            id: msgId,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            Swal.fire('Deleted!', response.message, 'success');
                            loadMessages();
                        },
                        error: function(err) {
                            Swal.fire('Error!', 'Something went wrong.', 'error');
                            console.log(err);
                        }
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    Swal.fire('Cancelled', 'Your record is safe :)', 'info');
                }

            });

        });
    </script>
@endsection
