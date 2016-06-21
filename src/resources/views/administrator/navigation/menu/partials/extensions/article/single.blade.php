<div class="box box-default">
	  <div class="box-header with-border">
			<h3 class="box-title font-s14">Single Article Parameters</h3>
	  </div>
	  <div class="box-body">
          <div id="menu-item-list-selected" style="margin-top:10px;">
              <div class="input-group">
                  <input id="selected-article-id" name="parameters[article_id]" value="{{ old('parameters.article_id', $menu->article()->id) }}" type="hidden">
                  <input id="selected-article-title" name="parameters[article_title]" value="{{ old('parameters.article_title', $menu->article()->title) }}" type="text" class="form-control" placeholder="Select an article" readonly>
            <span class="input-group-btn">
                <button @click="initArticleDataTable"
                    data-toggle="modal"
                    data-target="#articles-list-modal"
                    class="btn btn-default btn-flat"
                    type="button">
                    <i class="fa fa-file"></i>&nbsp;&nbsp;Select
                </button>
            </span>
              </div><!-- /input-group -->
          </div>

          <div style="margin-top: 10px">
              <label class="form-label-style block" for="url">URL
                  @tooltip('Link for this menu.')
                  @include('administrator.partials.icon-required')
              </label>
              <div class="input-group {!! $errors->has('url') ? 'has-error' : '' !!}">
                  <span class="input-group-addon site-label">{{asset('/')}}</span>
                  {!! form()->input('text', 'url', null, ['id'=>'url','class'=>'form-control','placeholder'=>'URL','readonly']) !!}
              </div>
              {!! $errors->first('url', '<span class="help-block text-danger">:message</span>') !!}
          </div>
      </div>
</div>