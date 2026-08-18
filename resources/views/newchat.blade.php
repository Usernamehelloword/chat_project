<!-- resources/views/chat.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">

    <div class="card">

        <div class="card-header">
            Chat with {{ $receiver->name }}
        </div>

        <div class="card-body">

            <div id="messages"
                 style="height:400px;overflow-y:auto;border:1px solid #ddd;padding:10px;">

                @foreach($messages as $message)

                    <div class="{{ $message->sender_id == auth()->id() ? 'text-end' : 'text-start' }} mb-2">

                        <span class="badge bg-{{ $message->sender_id == auth()->id() ? 'primary' : 'secondary' }}">
                            {{ $message->message }}
                        </span>

                    </div>

                @endforeach

            </div>

            <div class="mt-3 d-flex">

                <input
                    id="message"
                    class="form-control"
                    placeholder="Type message...">

                <button
                    class="btn btn-primary ms-2"
                    id="sendBtn">
                    Send
                </button>

            </div>

        </div>

    </div>

</div>
@endsection

@vite(['resources/js/app.js'])

<script>

const receiverId = {{ $receiver->id }};
const currentUser = {{ auth()->id() }};

document.getElementById('sendBtn').onclick = sendMessage;

document.getElementById('message').addEventListener('keypress', function(e){

    if(e.key==="Enter"){
        sendMessage();
    }

});

function appendMessage(message, mine=false){

    let div=document.createElement('div');

    div.className=mine
        ?'text-end mb-2'
        :'text-start mb-2';

    div.innerHTML=
        `<span class="badge bg-${mine?'primary':'secondary'}">
            ${message}
        </span>`;

    let box=document.getElementById('messages');

    box.appendChild(div);

    box.scrollTop=box.scrollHeight;

}

function sendMessage(){

    let input=document.getElementById('message');

    if(input.value=="") return;

    axios.post('/chat/send',{

        receiver_id:receiverId,

        message:input.value

    }).then(()=>{

        appendMessage(input.value,true);

        input.value='';

    });

}

Echo.private(`chat.${currentUser}`)

.listen('.message.sent',(e)=>{

    if(e.message.sender_id==receiverId){

        appendMessage(e.message.message,false);

    }

});

</script>