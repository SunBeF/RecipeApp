<x-app-layout>
    <div class="p-4 mx-auto bg-white rounded">
        {{ Breadcrumbs::render('show', $recipe) }}
        <div class="grid grid-cols-2 rounded border border-gray-400 mt-4">
            {{-- レシピの詳細 --}}
            <div class="col-span-1">
                <img class="object-cover aspect-square w-full mrounded-none" src="{{ $recipe['image'] }}"
                    alt="{{ $recipe['title'] }}">
            </div>
            <div class="col-span-1 p-4">
                <p class="mb-4">{{ $recipe['description'] }}</p>
                <p class="mb-4 text-gray-500">{{ $recipe['user']['name'] }}</p>
                <h4 class="text-2xl font-bold mb-2">材料</h4>
                @foreach ($recipe['ingredients'] as $i)
                    <ul class="text-gray-500 ml-5">
                        <li>{{ $i['name'] }}:{{ $i['quantity'] }}</li>
                    </ul>
                @endforeach
            </div>
        </div>
        <br>
        {{-- steps --}}
        <div>
            <h4 class="text-2xl font-bold mb-6">作り方</h4>
            <div class="grid grid-cols-4  gap-4">
                @foreach ($recipe['steps'] as $s)
                    <div class="mb-2 bg-color p-2  rounded ">
                        <div class="w-10 h-10 flex items-center justify-center bg-white rounded-full mr-4 mb-2">
                            {{ $s['step_number'] }}
                        </div>
                        <p> {{ $s['description'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @if ($is_my_recipe)
        <a href="{{ route('recipe.edit', ['id' => $recipe['id']]) }}"
            class="block w-2/12 p-4 my-4 mx-auto bg-green-700  rounded text-center text-white hover:bg-green-800">編集する</a>
    @endif
    {{--  reviews --}}
    @guest
        <p class="text-center text-gray-500">レビューを投稿するには<a href="{{ route('login') }}"
                class="text-blue-700 ">ログイン</a>してください</p>
    @endguest
    @auth
        @if ($is_reviewed)
            <p class="text-center text-gray-500 mb-4">レビューは投稿済みです</p>
        @elseif($is_my_recipe)
            <p class="text-center text-gray-500 mb-4">自分のレシピにはレビューできません</p>
        @else
            <div class="p-4 mx-auto bg-white rounded">
                <form action="{{ route('review.store', ['id' => $recipe['id']]) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">
                            評価
                        </label>
                        <select name="rating" id="rating"
                            class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-2 px-4 pr-8 rounded ">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3" selected>3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="comment">
                            コメント
                        </label>
                        <textarea name="comment" id="comment" cols="30" rows="10"
                            class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-2 px-4 pr-8 rounded "></textarea>
                    </div>
                    <div class="flex justify-center mt-4">
                        <button type="submit" class="bg-green-700 hover:bg-green-800 text-white py-2 px-4 rounded">
                            レビューを投稿する
                        </button>
                    </div>
                </form>
            </div>
        @endif
    @endauth
    <div class="p-4 mx-auto bg-white rounded">
        <h4 class="text-2xl font-bold mb-2 ">レビュー</h4>
        @if (count($recipe['reviews']) == 0)
            <p>まだレビューはありません</p>
        @endif
        @foreach ($recipe['reviews'] as $r)
            <div class="bg-color rounded mb-2 p-4">
                <div class="flex mb-4">
                    @for ($i = 0; $i < $r['rating']; $i++)
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="w-6 h-6 text-yellow-400">
                            <path fill-rule="evenodd"
                                d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z"
                                clip-rule="evenodd" />
                        </svg>
                    @endfor
                    <p class="ml-2"> {{ $r['comment'] }}</p>
                </div>
                <p class="font-bold text-gray-600 ">{{ $r['user']['name'] }}</p>
            </div>
        @endforeach
    </div>
</x-app-layout>
