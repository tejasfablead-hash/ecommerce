<!DOCTYPE html>
<html lang="zxx" class="no-js">

<head>
    <!-- Mobile Specific Meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon-->
    <link rel="shortcut icon" href="img/fav.png">
    <!-- Author Meta -->
    <meta name="author" content="CodePixar">
    <!-- Meta Description -->
    <meta name="description" content="">
    <!-- Meta Keyword -->
    <meta name="keywords" content="">
    <!-- meta character set -->
    <meta charset="UTF-8">
    <!-- Site Title -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Karma Shop</title>
    <!-- CSS ============================================= -->
    <style>
        #ai-chat-widget {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 9999;
        }

        #ai-chat-toggle {
            width: 55px;
            height: 55px;
            border-radius: 50%;
            border: none;
            background: #ff6c00;
            color: #fff;
            font-size: 24px;
            cursor: pointer;
        }

        #ai-chat-box {
            display: none;
            width: 320px;
            height: 420px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
            margin-bottom: 10px;
            overflow: hidden;
        }

        .ai-header {
            background: #ff6c00;
            color: #fff;
            padding: 10px;
            font-weight: bold;
            display: flex;
            justify-content: space-between;
        }

        #ai-reply {
            height: 300px;
            padding: 10px;
            overflow-y: auto;
            font-size: 14px;
        }

        #ai-reply div {
            margin-bottom: 6px;
        }

        .ai-footer {
            display: flex;
            padding: 10px;
            border-top: 1px solid #eee;
        }

        .ai-footer input {
            flex-grow: 1;
            border-radius: 20px;
            padding: 10px 16px;
            border: 1px solid #ccc;
        }

        .ai-footer button {
            margin-left: 5px;
        }

        .ai-footer button {
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

        .ai-footer button:hover {
            background: #e07f05;
        }

        #ai-reply {
            display: flex;
            flex-direction: column;
        }

        .ai-msg {
            max-width: 75%;
            padding: 8px 12px;
            margin: 4px 0;
            border-radius: 12px;
            word-break: break-word;
            font-size: 14px;
        }

        .ai-msg.user {
            align-self: flex-end;
            background: #ff6c00;
            color: #fff;
            border-bottom-right-radius: 4px;
        }

        .ai-msg.ai {
            align-self: flex-start;
            background: #f1f1f1;
            color: #333;
            border-bottom-left-radius: 4px;
        }
    </style>

    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/linearicons.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('css/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset('css/nouislider.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/ion.rangeSlider.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/ion.rangeSlider.skinFlat.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
</head>

<body>

    <!-- Start Header Area -->
    @include('Ecommerce.Layout.header')
    <!-- End Header Area -->


    @yield('container')
    <!-- start footer Area -->

    <div id="ai-chat-widget">
        <button id="ai-chat-toggle">🤖</button>

        <div id="ai-chat-box">
            <div class="ai-header">
                AI Assistant
                <span id="ai-close" style="cursor:pointer;">×</span>
            </div>

            <div id="ai-reply"></div>

            <div class="ai-footer">
                <input type="text" id="msg" placeholder="Ask me anything...">
                <button id="send-ai"><i class="bi bi-send-fill"></i></button>
            </div>
        </div>
    </div>
    <!-- ================= END AI CHAT ================= -->

    @include('Ecommerce.Layout.footer')
    <!-- End footer Area -->

    <script src="{{ asset('js/vendor/jquery-2.2.4.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"
        integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/vendor/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/jquery.ajaxchimp.min.js') }}"></script>
    <script src="{{ asset('js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('js/jquery.sticky.js') }}"></script>
    <script src="{{ asset('js/nouislider.min.js') }}"></script>
    <script src="{{ asset('js/countdown.js') }}"></script>
    <script src="{{ asset('js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('js/owl.carousel.min.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!--gmaps Js-->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjCGmQ0Uq4exrzdcL6rvxywDDOvfAu6eE"></script>
    <script src="{{ asset('js/gmaps.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('ajax.js') }}"></script>

    <script>
        const toggleBtn = document.getElementById('ai-chat-toggle');
        const chatBox = document.getElementById('ai-chat-box');
        const closeBtn = document.getElementById('ai-close');
        const sendBtn = document.getElementById('send-ai');
        const msgInput = document.getElementById('msg');
        const replyBox = document.getElementById('ai-reply');

        toggleBtn.onclick = () => {
            chatBox.style.display = 'block';
            msgInput.focus();
        };

        closeBtn.onclick = () => {
            chatBox.style.display = 'none';
        };

        msgInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                sendMessage();
            }
        });

        sendBtn.onclick = sendMessage;

        function appendMessage(sender, text) {
            const div = document.createElement('div');
            div.classList.add('ai-msg');
            if (sender === 'You') {
                div.classList.add('user');
            } else {
                div.classList.add('ai');
            }
            div.innerHTML = `<b>${sender}:</b> ${text}`;
            replyBox.appendChild(div);
            replyBox.scrollTop = replyBox.scrollHeight;
        }

        function sendMessage() {
            const msg = msgInput.value.trim();
            if (!msg) return;

            appendMessage('You', msg);
            msgInput.value = '';

            const loadingId = 'load-' + Date.now();
            replyBox.innerHTML += `<div id="${loadingId}"><i>AI is typing...</i></div>`;
            replyBox.scrollTop = replyBox.scrollHeight;

            fetch("{{ url('/ai/chat') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        message: msg
                    })
                })
                .then(res => res.json())
                .then(data => {
                    document.getElementById(loadingId)?.remove();
                    appendMessage('AI', data.reply || 'No response');
                })
                .catch(() => {
                    document.getElementById(loadingId)?.remove();
                    appendMessage('AI', 'Server error. Try again.');
                });

        }
    </script>

</body>

</html>
