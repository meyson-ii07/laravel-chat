<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>Laravel</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/chat.css') }}" rel="stylesheet">
    @csrf
</head>
<body>
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <img src="/uploads/avatars/{{ Auth::user()->avatar }}" style="width:32px; height:32px; bottom:2.5px; left:10px; border-radius:50%">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('profile') }}">
                                    {{ __('Profile') }}
                                </a>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>


{{--v2--}}
    <div class="container">
        <h3 class=" text-center">Chat</h3>
        <div class="messaging">
            <div class="inbox_msg align-content-center">

                <div class="mesgs">
                    <div class="msg_history">

                    </div>
                    <div class="type_msg">
                        <div class="input_msg_write">
                            <input id="message" type="text" onkeydown="send(event)" class="write_msg" placeholder="Type a message" />
                            <button class="msg_send_btn" type="button"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <script src="{{asset('js/app.js')}}"></script>
    <script>



        const user_id = {{\Illuminate\Support\Facades\Auth::id()}}
        function send(event)
        {
            if(event.code === "Enter" && $("#message").val()!=="")
            {
                axios.post('/message', {
                    'text': $("#message").val()
                });
                $("#message").val("");
            }
        };

        function  addNewMessage(info) {
            function formatAMPM(date) {
                let hours = date.getHours();
                let minutes = date.getMinutes();
                let ampm = hours >= 12 ? 'PM' : 'AM';
                hours = hours % 12;
                hours = hours ? hours : 12; // the hour '0' should be '12'
                minutes = minutes < 10 ? '0'+minutes : minutes;
                let strTime = hours + ':' + minutes + ' ' + ampm;
                return strTime;
            }

            let date = formatAMPM(new Date());

            let message_block;
            if (user_id === info.user.id) {
              message_block = ' <div class="outgoing_msg">\n' +
                  '<div class="sent_msg">\n' +
                  '<p>'+info.message+'</p>\n' +
                  '<span class="time_date">'+date+'</span> </div>\n' +
                  '</div>'
            }
            else
            {
                message_block ='<div class="incoming_msg">\n' +
                    '<div class="incoming_msg_img"><img class="user_photo" src="/uploads/avatars/'+info.user.avatar+'" alt="sunil"> </div>\n' +
                    '<div class="received_msg">\n' +
                    '<p class="user-name">'+info.user.name+'</p>\n' +
                    '<div class="received_withd_msg">\n' +
                    '<p>'+info.message+'</p>\n' +
                    '<span class="time_date">'+date+'</span></div>\n' +
                    '</div>\n'+
                    '</div>';
            }

            let msg_history = $(".msg_history");
            msg_history.append(message_block);
            msg_history.scrollTop($(".msg_history")[0].scrollHeight);
        }
        Echo.channel('chat')
             .listen('NewMessage',(e)=>{
                 addNewMessage(e);
             });

    </script>

</body>
</html>


