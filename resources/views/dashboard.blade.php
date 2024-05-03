<x-app-layout>
    <style>
        .c_flex {
            display: flex;
            flex-direction: row;
        }
    </style>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>

        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="custom-form">
                        <form action="{{ route('add_word') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="title">Nom</label>
                                <input required type="text" id="title" name="title">
                                @error('title')
                                    <div class="alert alert-danger" role="alert">
                                        {{ $errors->first('title') }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label required for="">Choisir une image <span style="color: red">(jpg, png,
                                        gif)</span></label>
                                <input type="file" name="fileToUpload" id="fileToUpload"
                                    onchange="previewImage(event)">

                                @error('fileToUpload')
                                    <div class="alert alert-danger" role="alert">
                                        {{ $errors->first('fileToUpload') }}
                                    </div>
                                @enderror
                                <img id="preview" width="200">
                            </div>
                            <div class="form-group">
                                <input type="submit" value="Valider" name="submit">
                            </div>
                        </form>
                    </div>
                    @if (count($words) > 0)
                        <div class="flex flex-wrap flex-row mx-4 m-20">
                            @foreach ($words as $item)
                                <div
                                    class="flex flex-col mt-6 text-gray-700 bg-white shadow-md bg-clip-border rounded-xl w-50">
                                    <div class="p-6 border-b-10">
                                        <h5
                                            class="block mb-2  font-sans text-xl antialiased text-center uppercase font-semibold leading-snug tracking-normal text-blue-gray-900">
                                            {{ ucfirst($item['title']) }}
                                        </h5>
                                    </div>
                                    <div
                                        class="flex justify-center align-center">
                                        <img class="w-40 h-40" src="{{ asset($item['path']) }}" alt="{{ $item['title'] }}" />
                                    </div>
                                    <div class="p-6 pt-10">
                                        <a href="{{ route('edit_word', $item['id']) }}">
                                            <button
                                                class="align-middle select-none font-sans font-bold text-center uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none text-xs py-3 px-6 rounded-lg bg-gray-900 text-white shadow-md shadow-gray-900/10 hover:shadow-lg hover:shadow-gray-900/20 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none"
                                                type="button">
                                                Modifier
                                            </button>
                                        </a>
                                        <a href="{{ route('word.delete_word', $item['id']) }}">
                                            <button
                                                class="align-middle select-none font-sans font-bold text-center uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none text-xs py-3 px-6 rounded-lg bg-gray-900 text-white shadow-md shadow-gray-900/10 hover:shadow-lg hover:shadow-gray-900/20 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none"
                                                type="button">
                                                Supprimer
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script>
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('preview');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }

        setTimeout(function() {
            document.querySelector('.alert-success').style.display = 'none';
        }, 5000);
    </script>
</x-app-layout>
