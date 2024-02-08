<form action="" method="post" class="vstack gap-2">
    @csrf 
    @method($post->id ? 'PATCH' :'POST')
    <div class="form-group">
        <label for="title">Titre</label>
        <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $post->title) }}">
        @error('title')
            {{ $message}}
        @enderror
    </div>
    <div class="form-group">
        <label for="slug">Slug</label>
        <input type="text" class="form-control" id="slug" name="slug" value="{{ old('slug', $post->slug) }}">
        @error('slug')
            {{ $message}}
        @enderror
    </div>
    <div class="form-group">
        <label for="content">Content</label>
        <textarea id="content" class="form-control" name="content">{{ old('content', $post->content) }}</textarea>
        @error('content')
            {{ $message}}
        @enderror
    </div>
    <button class="btn btn-primary">
        @if($post->id)
            Modifier
        @else
            Créer
        @endif
    </button>
</form>