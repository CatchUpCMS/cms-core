<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label class="form-label-style block" for="author_alias">
                {{trans('article.field.author_alias')}}
                @tooltip('article.tooltip.author_alias')
            </label>
            {!! form()->input('text','author_alias', null, ['id'=>'author_alias','class'=>'form-control','placeholder'=>trans('article.field.author_alias_placeholder')]) !!}
        </div>
        <div class="form-group">
            <label class="form-label-style block" for="meta_description">
                {{trans('article.field.meta_description')}}
                @tooltip('article.tooltip.meta_description')
            </label>
            {!! form()->textarea('parameters[meta_description]', $article->fluentParameters()->meta_description, ['placeholder' => trans('article.field.meta_description_placeholder'), 'class' => 'form-control', 'rows' => 3, 'cols' => 3]) !!}
        </div>
        <div class="form-group">
            <label class="form-label-style block" for="meta_keywords">
                {{trans('article.field.meta_keywords')}}
                @tooltip('article.tooltip.meta_keywords')
            </label>
            {!! form()->textarea('parameters[meta_keywords]', $article->fluentParameters()->meta_keywords, ['placeholder' => trans('article.field.meta_keywords_placeholder'), 'class' => 'form-control', 'rows' => 3, 'cols' => 3]) !!}
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label class="form-label-style block" for="key_reference">
                {{trans('article.field.key_reference')}}
                @tooltip('article.tooltip.key_reference')
            </label>
            {!! form()->text('parameters[key_reference]', $article->fluentParameters()->key_reference, ['placeholder' => trans('article.field.key_reference_placeholder'), 'class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            <label class="form-label-style block" for="content_rights">
                {{trans('article.field.content_rights')}}
                @tooltip('article.tooltip.content_rights')
            </label>
            {!! form()->textarea('parameters[content_rights]', $article->fluentParameters()->content_rights, ['placeholder' => trans('article.field.content_rights_placeholder'), 'class' => 'form-control', 'rows' => 3, 'cols' => 3]) !!}
        </div>
        <div class="form-group">
            <label class="form-label-style block" for="external_reference">
                {{trans('article.field.external_reference')}}
                @tooltip('article.tooltip.external_reference')
            </label>
            {!! form()->text('parameters[external_reference]', $article->fluentParameters()->external_reference, ['placeholder' => trans('article.field.external_reference'), 'class' => 'form-control']) !!}
        </div>
    </div>
</div>