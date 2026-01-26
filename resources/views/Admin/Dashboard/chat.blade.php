@extends('Admin.Pages.index')
@section('container')
<div class="nxl-container">
    <div class="nxl-content">

        <div class="row" style="height:80vh;">
            <!-- LEFT CHAT LIST -->
            <div class="col-md-4 border-end p-0 bg-light d-flex flex-column">
                <div class="p-3 border-bottom fw-bold bg-white d-flex justify-content-between align-items-center">
                    <span>Chats</span>
                    <button class="btn btn-sm btn-outline-secondary" id="refresh-chats"><i class="bi bi-arrow-clockwise"></i></button>
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
                            <li class="list-group-item chat-user d-flex justify-content-between align-items-center px-3 py-2"
                                data-id="{{ $user->id }}" style="cursor:pointer;">
                                <div class="d-flex align-items-center">
                                    <div class="me-2">
                                        <span class="badge bg-secondary rounded-circle" style="width:40px; height:40px; display:inline-flex; align-items:center; justify-content:center;">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </span>
                                    </div>
                                    <div class="text-truncate" style="max-width:150px;">
                                        <strong>{{ $user->name }}</strong><br>
                                        <small class="text-muted text-truncate">{{ $lastMessage }}</small>
                                    </div>
                                </div>
                                @if($unread)
                                    <span class="badge bg-danger rounded-pill unread-count">{{ $unread }}</span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- RIGHT CHAT BOX -->
            <div class="col-md-8 d-flex flex-column p-0 bg-white">
                <div class="border-bottom p-3 d-flex justify-content-between align-items-center">
                    <h5 id="chat-title" class="mb-0">Select a chat</h5>
                    <button class="btn btn-sm btn-outline-secondary" id="refresh-chat"><i class="bi bi-arrow-clockwise"></i></button>
                </div>
                <div class="flex-grow-1 p-3 overflow-auto" id="chat-box" style="background:#f8f9fa;"></div>
                <div class="border-top p-3 bg-white">
                    <div class="input-group">
                        <input type="text" id="chat-message" class="form-control" placeholder="Type a message..." autocomplete="off">
                        <button class="btn btn-primary" id="send-chat"><i class="bi bi-send"></i> Send</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- JS for Chat -->
<script>
let activeChat = null;

// Select chat
$(document).on('click', '.chat-user', function() {
    activeChat = $(this).data('id');
    $('#chat-title').text('Chat with ' + $(this).find('strong').text());
    $('.chat-user').removeClass('active bg-white');
    $(this).addClass('active bg-white shadow-sm');
    loadMessages();
});

// Send chat
$('#send-chat').on('click', function() {
    let msg = $('#chat-message').val().trim();
    if (!msg || !activeChat) return;

    $.post("{{ route('AdminchatSend') }}", {
        user_id: activeChat,
        message: msg,
        _token: "{{ csrf_token() }}"
    }, function() {
        $('#chat-message').val('');
        loadMessages();
        updateUnread(activeChat, 0);
    });
});

// Load messages
let chatUrlTemplate = "{{ route('AdminchatShow', ['chatId' => ':id']) }}";
function loadMessages() {
    if (!activeChat) return;
    let url = chatUrlTemplate.replace(':id', activeChat);

    $.get(url, function(res) {
        $('#chat-box').html('');
        res.forEach(m => {
            let align = m.sender_id === {{ auth()->id() }} ? 'text-end' : 'text-start';
            let color = m.sender_id === {{ auth()->id() }} ? 'primary' : 'secondary';
            $('#chat-box').append(`
                <div class="mb-2 d-flex ${align === 'text-end' ? 'justify-content-end' : ''}">
                    <span class="badge bg-${color} p-2 rounded">${m.message}</span>
                </div>
            `);
        });
        $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight);
    });
}

// Update unread badge
function updateUnread(userId, count) {
    let badge = $(`.chat-user[data-id='${userId}'] .unread-count`);
    badge.text(count);
    if(count == 0) badge.hide();
    else badge.show();
}

// Auto refresh
setInterval(loadMessages, 3000);

// Manual refresh
$('#refresh-chat').on('click', loadMessages);
$('#refresh-chats').on('click', function() { location.reload(); });
</script>

<style>
/* Scrollbar customization */
#chat-box::-webkit-scrollbar,
#chat-users::-webkit-scrollbar {
    width: 6px;
}
#chat-box::-webkit-scrollbar-thumb,
#chat-users::-webkit-scrollbar-thumb {
    background-color: rgba(0,0,0,0.2);
    border-radius: 3px;
}
.chat-user.active {
    background-color: #ffffff !important;
    border-left: 4px solid #0d6efd;
}
</style>
@endsection
