@extends('Admin.Pages.index')

@section('container')
    <style>
        body {
            background: #eef2f7;
        }

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


        .chat-input {
            border-radius: 30px;
            padding: 10px 16px;
        }

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

        .chat-middle {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        #chat-box {
            flex-grow: 1;
            overflow-y: auto;
            padding-bottom: 10px;
        }

        .chat-footer {
            position: sticky;
            bottom: 0;
            background: #fff;
            z-index: 20;
            border-top: 1px solid #dee2e6;
        }

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

            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Chat</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item">Chat</li>
                    </ul>
                </div>
                <div class="page-header-right ms-auto">
                    <div class="page-header-right-items">
                        <div class="d-flex d-md-none">
                            <a href="javascript:void(0)" class="page-header-right-close-toggle">
                                <i class="feather-arrow-left me-2"></i>
                                <span>Back</span>
                            </a>
                        </div>
                        <div class="d-flex align-items-center gap-2 page-header-right-items-wrapper">
                            <a href="{{ route('DashboardPage') }}" class="btn btn-primary ">
                                <i class="feather-arrow-left me-2"></i>
                                <span>Back</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

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
                                                    <span class="badge bg-primary rounded-pill unread-count ">
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
    <script src="{{ asset('ajax.js') }}"></script>
    <script>
  let activeChat = null;
let isEditing = false;
let editingMessageId = null;
let lastMessageId = 0;

$(document).on('click', '.chat-user', function() {
    activeChat = $(this).data('id');
    $('.chat-user').removeClass('active');
    $(this).addClass('active');

    $('#chat-title').text($(this).find('strong').text());
    $('#chat-avatar').text($(this).find('.avatar').text());
    $(this).find('.unread-count').fadeOut(200);

    lastMessageId = 0; // Reset when switching chat
    $('#chat-box').html(''); // clear old messages
    loadMessages(true); // force scroll to bottom
});

// Send or update message
$('#send-chat').on('click', function() {
    let msg = $('#chat-message').val().trim();
    if (!msg || !activeChat) return;

    let formData = new FormData();
    let url = "";

    if (isEditing && editingMessageId) {
        formData.append('id', editingMessageId);
        formData.append('message', msg);
        url = "{{ route('AdminchatUpdate') }}";

        // AJAX update
        reusableAjaxCall(url, 'POST', formData, function(response) {
            let updatedMsgBox = $(`.chat-msg[data-id="${editingMessageId}"]`);
            updatedMsgBox.find('.chat-text').text(msg);
            updatedMsgBox.css('background', '#fff3cd');
            setTimeout(() => updatedMsgBox.css('background', ''), 1000);

            resetEdit();
            $('#chat-message').val('');
        });
    } else {
        formData.append('user_id', activeChat);
        formData.append('message', msg);
        url = "{{ route('AdminchatSend') }}";

        reusableAjaxCall(url, 'POST', formData, function(response) {
            $('#chat-message').val('');
            loadMessages(true); // scroll to bottom
        });
    }
});

function resetEdit() {
    isEditing = false;
    editingMessageId = null;
    $('#chat-message').val('');
}

// Edit message click
$(document).on('click', '.edit-msg', function(e) {
    e.preventDefault();
    e.stopPropagation();

    let box = $(this).closest('.chat-msg');
    editingMessageId = box.data('id');
    let text = box.find('.chat-text').text().trim();
    $('#chat-message').val(text).focus();

    isEditing = true;
});

// Delete message
$(document).on('click', '.delete-msg', function(e) {
    e.preventDefault();
    e.stopPropagation();

    let msgId = $(this).closest('.chat-msg').data('id');
    let formData = new FormData();
    formData.append('id', msgId);

    Swal.fire({
        title: 'Delete message?',
        text: 'This cannot be undone',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Delete'
    }).then((result) => {
        if (result.value == true) {
            reusableAjaxCall("{{ route('AdminchatDelete') }}", 'POST', formData, function(response) {
                $(`.chat-msg[data-id="${msgId}"]`).remove();
                Swal.fire('Deleted!', response.message, 'success');
            });
        }
    });
});

// Load messages
let chatUrlTemplate = "{{ route('AdminchatShow', ['chatId' => ':id']) }}";

function loadMessages(forceScroll = false) {
    if (!activeChat) return;

    let url = chatUrlTemplate.replace(':id', activeChat);
    reusableAjaxCall(url, 'GET', {}, function(messages) {
        let chatBox = $('#chat-box');
        let isAtBottom = chatBox.scrollTop() + chatBox.innerHeight() >= chatBox[0].scrollHeight - 20;

        messages.forEach(m => {
            if ($('#chat-box').find(`.chat-msg[data-id="${m.id}"]`).length === 0) {
                let isMe = m.sender_id === {{ auth()->id() }};
                chatBox.append(`
                    <div class="chat-row ${isMe ? 'me' : ''}">
                        <div class="chat-bubble ${isMe ? 'me' : 'other'} chat-msg" data-id="${m.id}">
                            <span class="chat-text">${m.message}</span>
                            ${isMe ? `
                                <div class="msg-actions dropdown">
                                    <span data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </span>
                                    <ul class="dropdown-menu dropdown-menu-end shadow">
                                        <li><a class="dropdown-item edit-msg" href="javascript:void(0)">
                                            <i class="bi bi-pencil me-2"></i>Edit
                                        </a></li>
                                        <li><a class="dropdown-item text-danger delete-msg" href="javascript:void(0)">
                                            <i class="bi bi-trash me-2"></i>Delete
                                        </a></li>
                                    </ul>
                                </div>` : ''}
                        </div>
                    </div>
                `);
            }
        });

        if (forceScroll || isAtBottom) chatBox.scrollTop(chatBox[0].scrollHeight);
    });
}

// Auto-refresh messages
setInterval(() => {
    if (activeChat && !isEditing) loadMessages();
}, 4000);

    </script>
@endsection
