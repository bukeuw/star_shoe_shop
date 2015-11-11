{{-- FIXME: crap, too many logic in a view --}}

<div class="form-group">
	<label for="categories" class="col-sm-2 control-label">Kategori</label>
	<div class="col-sm-6">
		<select class="form-control" name="categories[]" id="categories" multiple>
			@foreach($categories as $category)
				@if($category->parent_id == 0)
					<optgroup label="{{ $category->title }}">
					@foreach($categories as $child_category)
						@if($child_category->parent_id == $category->id)
							<option value="{{ $child_category->id }}" 
							@if(isset($product))
								{{ $product->categories()->get()->contains($child_category->id)? 'selected':'' }}
							@endif
							>
								{{ $child_category->title }}
							</option>
						@endif
					@endforeach
					</optgroup>
				@endif
			@endforeach
		</select>
	</div>
</div>