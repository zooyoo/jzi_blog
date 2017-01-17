<div class="row">
    <div class="col-md-8">
        <div class="form-group">
            <label for="title" class="col-md-2 control-label">
                标题
            </label>
            <div class="col-md-10">
                <input type="text" class="form-control" name="title" autofocus id="title" value="{{ $title }}">
            </div>
        </div>
        <div class="form-group">
            <label for="subtitle" class="col-md-2 control-label">
                副标题
            </label>
            <div class="col-md-10">
                <input type="text" class="form-control" name="subtitle" id="subtitle" value="{{ $subtitle }}">
            </div>
        </div>
        <div class="form-group">
            <label for="page_image" class="col-md-2 control-label">
                文章图片
            </label>
            <div class="col-md-10">
                <div class="row">
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="page_image" id="page_image" onchange="handle_image_change()" alt="Image thumbnail" value="{{ $page_image }}">
                    </div>
                    <script>
                        function handle_image_change() {
                            $("#page-image-preview").attr("src", function () {
                                var value = $("#page_image").val();
                                if ( ! value) {
                                    value = {!! json_encode(config('blog.page_image')) !!};
                                    if (value == null) {
                                        value = '';
                                    }
                                }
                                if (value.substr(0, 4) != 'http' && value.substr(0, 1) != '/') {
                                    value = {!! json_encode(config('blog.uploads.webpath')) !!} + '/' + value;
                                }
                                return value;
                            });
                        }
                    </script>
                    <div class="visible-sm space-10"></div>
                    <div class="col-md-4 text-right">
                        <img src="{{ page_image($page_image) }}" class="img img_responsive" id="page-image-preview" style="max-height:40px">
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="content" class="col-md-2 control-label">
                内容
            </label>
            <div class="col-md-10">
                <textarea class="form-control" name="content" rows="14" id="content">{{ $content }}</textarea>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="update_date" class="col-md-3 control-label">
                发布日期
            </label>
            <div class="col-md-8">
                <input class="form-control" name="update_date" id="update_date" type="text" value="{{ $update_date }}">
            </div>
        </div>
        <div class="form-group">
            <label for="update_time" class="col-md-3 control-label">
                发布时间
            </label>
            <div class="col-md-8">
                <input class="form-control" name="update_time" id="update_time" type="text" value="{{ $update_time }}">
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-8 col-md-offset-3">
                <div class="checkbox">
                    <label>
                        <input {{ checked($is_draft) }} type="checkbox" name="is_draft">
                        草稿?
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="tags" class="col-md-3 control-label">
                标签
            </label>
            <div class="col-md-8">
                <select name="tags[]" id="tags" class="form-control" multiple>
                    @foreach ($allTags as $tag)
                        <option @if (in_array($tag, $tags)) selected @endif value="{{ $tag }}">
                            {{ $tag }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="layout" class="col-md-3 control-label">
                布局
            </label>
            <div class="col-md-8">
                <input type="text" class="form-control" name="layout" id="layout" value="{{ $layout }}">
            </div>
        </div>
        <div class="form-group">
            <label for="meta_description" class="col-md-3 control-label">
                Meta
            </label>
            <div class="col-md-8">
                <textarea class="form-control" name="meta_description" id="meta_description" rows="6">
                    {{ $meta_description }}
                </textarea>
            </div>
        </div>

    </div>
</div>