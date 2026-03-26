<x-layout>
<div class="max-w-xl mx-auto py-6 px-8 my-20 bg-white rounded shadow-xl">
  @if ($errors)
    @foreach ($errors->all() as $error)
      <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative my-4" role="alert">
        <span class="block sm:inline">{{ $error }}</span>
      </div>
    @endforeach
  @endif
  <form id="downloadForm" action="{{ route('login') }}"  method="POST">
  @csrf
    <div class="mb-6">
      <label for="email" class="block text-gray-800 font-bold">Email:</label>
      <input type="text" name="email" id="email" placeholder="@email" class="w-full border border-gray-300 py-2 pl-3 rounded mt-2 outline-none focus:ring-indigo-600 :ring-indigo-600" />
    </div>
    <div class="mb-6">
      <label for="password" class="block text-gray-800 font-bold">Пароль:</label>
      <input type="password" name="password" id="password" placeholder="Пароль" class="w-full border border-gray-300 py-2 pl-3 rounded mt-2 outline-none focus:ring-indigo-600 :ring-indigo-600" />
    </div>
    <button type="submit" id="submitBtn" class="flex justify-center space-x-4 cursor-pointer py-2 px-4 mt-6 bg-primary text-white font-bold w-full text-center rounded">
        <span>Login</span>
    </button>
    
    <div id="error" class="text-red-600 my-2"></div>
  </form>
</div>
</x-layout>