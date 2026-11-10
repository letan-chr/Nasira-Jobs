<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            {{ Form::label('title', __('messages.post.title') . ':', ['class' => 'pb-2 fs-5 text-gray-600']) }}
            <p class="fs-5 text-gray-800">{{ html_entity_decode($post->title) }}</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            {{ Form::label('blog_category', __('messages.post_category.post_category') . ':', ['class' => 'pb-2 fs-5 text-gray-600']) }}
            <br>
            <div class="post-detail-category-badge">
                @forelse($post->postAssignCategories->pluck('name')->toArray() as $categoryBadges)
                    <span class="badge bg-pill bg-{{ getBadgeColor($loop->index) }}">{{ $categoryBadges }}</span>
                @empty
                    {{ __('messages.common.n/a') }}
                @endforelse
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            {{ Form::label('attachment', __('messages.post.image') . ':', ['class' => 'pb-2 fs-5 text-gray-600']) }}
            <br>
            @if (!empty($post->blog_image_url) && !empty($post->media[0]->id))
                <a href="{{ $post->blog_image_url }}" target="_blank"
                    class="text-decoration-none">{{ __('messages.common.view') }}</a>&nbsp;
                <a href="{{ route('download.post') . '/' . $post->media[0]->id }}"
                    class="text-decoration-none">{{ __('messages.common.download') }}</a>
            @else
                {{ __('messages.n/a') }}
            @endif
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            {{ Form::label('notes', __('messages.post.description') . ':', ['class' => 'pb-2 fs-5 text-gray-600']) }}
            <p class="fs-5 text-gray-800">{!! !empty($post->description) ? nl2br($post->description) : __('messages.n/a') !!}</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            {{ Form::label('created_at', __('messages.common.created_on') . ':', ['class' => 'pb-2 fs-5 text-gray-600']) }}
            <br>
            <span data-bs-toggle="tooltip" data-bs-placement="right"
                title="{{ date('jS M, Y', strtotime($post->created_at)) }}"
                class="fs-5 text-gray-800">{{ $post->created_at->diffForHumans() }}</span>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            {{ Form::label('updated_at', __('messages.common.last_updated') . ':', ['class' => 'pb-2 fs-5 text-gray-600']) }}
            <br>
            <span data-bs-toggle="tooltip" data-bs-placement="right"
                title="{{ date('jS M, Y', strtotime($post->updated_at)) }}"
                class="fs-5 text-gray-800">{{ $post->updated_at->diffForHumans() }}</span>
        </div>
    </div>
</div>
