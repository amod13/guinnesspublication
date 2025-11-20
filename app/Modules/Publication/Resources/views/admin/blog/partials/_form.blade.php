<form class="row g-3"
    action="{{ isset($data['record']->id) ? route('blog.update', $data['record']->id) : route('blog.store') }}"
    method="POST" enctype="multipart/form-data">
    @csrf
    @isset($data['record']->id)
        @method('PUT')
    @endisset


    <div class="col-md-12 mb-3">
        <x-form.select-input :id="'blog_category_id'" :label="'Blog Category'" :name="'blog_category_id'"
            :options="$data['blogCategories']->pluck('title', 'id')->toArray()"
            :value="old('blog_category_id', $data['record']->blog_category_id ?? '')" />
    </div>

       <div class="col-md-6 mb-3">
        <x-form.text-input :id="'title'" :label="'Title'" :name="'title'" :value="old('title', $data['record']->title ?? '')" />
    </div>

    <div class="col-md-6 mb-3">
        <x-form.text-input :id="'author_name'" :label="'Author Name'" :name="'author_name'" :value="old('author_name', $data['record']->author_name ?? '')" />
    </div>

    <div class="col-12 mb-3">
        <x-form.textarea :id="'excerpt'" :label="'Excerpt'" :name="'excerpt'" :value="old('excerpt', $data['record']->excerpt ?? '')" :rows="3" />
    </div>

    <div class="col-12 mb-3">
        <label for="tags" class="form-label">Tags</label>
        <div class="tags-container" id="tags-container">
            <div class="tags-display" id="tags-display"></div>
            <input type="text" class="tags-input" id="tags-input" placeholder="Type and press Enter or Space to add tags">
        </div>
        <div id="tags-hidden-inputs"></div>
        <small class="form-text text-muted">Type a tag and press Enter or Space to add it</small>
    </div>

    <div class="col-md-6 mb-3">
        <x-form.date-input :id="'published_date'" :label="'Published Date'" :name="'published_date'" :value="old('published_date', $data['record']->published_date ?? '')" />
    </div>

    <div class="col-md-6 mb-3">
        <x-form.select-input :id="'is_published'" :label="'Published'" :name="'is_published'" :options="['1' => 'Yes', '0' => 'No']"
            :value="(string) old('is_published', $data['record']->is_published ?? '0')" />
    </div>

    @isset($data['record']->id)
        <div class="col-md-6 mb-3">
            <x-form.select-input :id="'status'" :label="'Status'" :name="'status'" :options="['1' => 'Active', '0' => 'Inactive']"
                :value="(string) old('status', $data['record']->status ?? '1')" />
        </div>
    @endisset

    <div class="col-12 mb-3">
        <x-form.file-upload :id="'thumbnail_image'" :label="'Thumbnail Image'" :name="'thumbnail_image'" :value="isset($data['record']) ? $data['record']->getMediaUrl('thumbnail_image') : null" />
    </div>

    <div class="col-12 mb-3">
        <x-form.textarea :id="'content'" :editor="true" :label="'Content'" :name="'content'" :value="old('content', $data['record']->content ?? '')" :rows="10" />
    </div>

    <div class="col-12 col-lg-12 button_submit pt-20 d-flex justify-content-end">
        <x-form.submit-button :label="'Submit'" />
    </div>

</form>

<style>
.tags-container {
    border: 1px solid #ced4da;
    border-radius: 0.375rem;
    padding: 0.375rem;
    min-height: 38px;
    display: flex;
    flex-wrap: wrap;
    gap: 5px;
    align-items: center;
    cursor: text;
}
.tags-container:focus-within {
    border-color: #86b7fe;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}
.tag-item {
    background: #007bff;
    color: white;
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 12px;
    display: flex;
    align-items: center;
    gap: 5px;
}
.tag-remove {
    cursor: pointer;
    font-weight: bold;
}
.tags-input {
    border: none;
    outline: none;
    flex: 1;
    min-width: 100px;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tagsContainer = document.getElementById('tags-container');
    const tagsInput = document.getElementById('tags-input');
    const tagsDisplay = document.getElementById('tags-display');
    const tagsHidden = document.getElementById('tags-hidden');

    let tags = [];

    // Load existing tags
    @if(isset($data['record']->tags) && is_array($data['record']->tags))
        tags = @json($data['record']->tags);
        renderTags();
    @endif

    function renderTags() {
        tagsDisplay.innerHTML = '';
        const hiddenContainer = document.getElementById('tags-hidden-inputs');
        hiddenContainer.innerHTML = '';

        tags.forEach((tag, index) => {
            const tagElement = document.createElement('span');
            tagElement.className = 'tag-item';
            tagElement.innerHTML = `${tag} <span class="tag-remove" onclick="removeTag(${index})">&times;</span>`;
            tagsDisplay.appendChild(tagElement);

            // Create hidden input for each tag
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = `tags[${index}]`;
            hiddenInput.value = tag;
            hiddenContainer.appendChild(hiddenInput);
        });
    }

    function addTag(tagText) {
        const tag = tagText.trim();
        if (tag && !tags.includes(tag)) {
            tags.push(tag);
            renderTags();
        }
        tagsInput.value = '';
    }

    window.removeTag = function(index) {
        tags.splice(index, 1);
        renderTags();
    }

    tagsInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            addTag(this.value);
        } else if (e.key === 'Backspace' && this.value === '' && tags.length > 0) {
            tags.pop();
            renderTags();
        }
    });

    tagsContainer.addEventListener('click', function() {
        tagsInput.focus();
    });
});
</script>
