@extends('layouts.chat_app')

@section('content')
    <div class="container">
        <chats :user="{{ $current_user }}"></chats>
    </div>
@endsection
