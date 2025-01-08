
@extends('layouts.masyarakat')

@section('title')
Dashboard
@endsection
@section('content')
<main class="h-full pb-16 overflow-y-auto">
  {{-- @foreach($liat as $li)
 <li>{{ $li->NIK}}</li>
  @endforeach --}}
  <div class="container px-6 mx-auto grid">
    <h2 class="my-6 text-2xl font-semibold text-center text-gray-700 dark:text-gray-200">
        Detail Postingan
    </h2>
    @if ($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach($errors->all() as $error)
        <li>{{ $error }} </li>
        @endforeach
      </ul>
    </div>
    @endif
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-md p-6">

                <div class="mb-4">
                    <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="border rounded-lg shadow-md w-full h-[500px] object-cover">
                </div>

                <div class="mb-4">
                    <p class="text-gray-700 text-xl">{{ $post->caption }}</p>
                </div>

                <div class="mt-6">
                    <h4 class="text-lg font-bold mb-4">Komentar</h4>
                    @foreach($post->comments as $comment)
                        <div class="mb-4 border-b pb-4">
                            <p class="text-gray-800"><strong>{{ $comment->user_name }}</strong></p>
                            <p class="text-gray-700">{{ $comment->comment }}</p>
                            <p class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</p>

                            <div class="flex items-center space-x-4 mt-2">
                                @foreach(['👍', '❤️', '😂', '😮', '😢'] as $emoji)
                                    <form action="{{ route('comments.reactions.store', $comment) }}" method="POST">
                                        @csrf

                                        <input type="hidden" name="reaction" value="{{ $emoji }}">
                                        <button type="submit" class="text-xl">{{ $emoji }}</button>
                                    </form>
                                    <span>{{ $comment->reactions->where('reaction', $emoji)->count() }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6">
                    <h4 class="text-lg font-bold mb-2">Tambahkan Komentar</h4>
                    <form action="{{ route('comments.store', $post) }}" method="POST">
                        @csrf
                        <textarea name="comment" rows="4"
                                  class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-500"
                                  placeholder="Tulis komentar Anda di sini..." required></textarea>
                        @error('comment')
                        <p class="text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                        <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-3">
                            Kirim Komentar
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</main>
@endsection

