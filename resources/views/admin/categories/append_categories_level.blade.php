<div class="form-group">
    <label>აირჩიეთ კატეგორიის დონე</label>
    <select class="form-control select2" name="parent_id" id="parent_id" style="width: 100%;">
        <option value="0" @if(isset($categorydata['parent_id']) && $categorydata['parent_id']==0) selected="" @endif>მთავარი კატეგორია</option>
        @if(!empty($getCategories))
            @foreach($getCategories as $category)
                <option value="{{ $category['id'] }}" @if(isset($categorydata['parent_id']) && $categorydata['id']==0) selected="" @endif>{{ $category['category_name'] }}</option>
                    @if(!empty($category['subcategories']))
                        @foreach($category['subcategories'] as $subcategory)
                            <option value="{{ $subcategory['id'] }}">&nbsp;&raquo;&nbsp;{{ $subcategory['category_name'] }}</option>
                        @endforeach
                    @endif
            @endforeach
        @endif
    </select>
</div>