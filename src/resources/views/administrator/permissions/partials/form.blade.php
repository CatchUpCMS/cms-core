<div class="box box-primary">
    <div class="box-header with-border">
        <h3 style="color: #505b69;" class="box-title">PERMISSION INFORMATION
            <small>
                (please fill up all required fields.)
            </small>
        </h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group {!! $errors->has('name') ? 'has-error' : '' !!}">
                    <label class="form-label-style" for="name">Name</label>
                    {!! form()->input('text', 'name', null, ['id'=>'name','class'=>'form-control','placeholder'=>'Enter name here']) !!}
                    {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
                </div>
                <div class="form-group {!! $errors->has('slug') ? 'has-error' : '' !!}">
                    <label class="form-label-style" for="slug">Slug</label>
                    {!! form()->input('text', 'slug', null, ['id'=>'slug','class'=>'form-control','placeholder'=>'Enter slug here']) !!}
                    {!! $errors->first('slug', '<span class="help-block">:message</span>') !!}
                </div>
                <div class="form-group {!! $errors->has('resource') ? 'has-error' : '' !!}">
                    <label class="form-label-style" for="resource">Resource Name</label>
                    {!! form()->input('text', 'resource', null, ['id'=>'resource','class'=>'form-control','placeholder'=>'Resource Name']) !!}
                    {!! $errors->first('resource', '<span class="help-block">:message</span>') !!}
                </div>
            </div>
            <div class="col-md-6">
                @include('administrator.permissions.partials.roles-form')
            </div>
        </div>
    </div>
    <div class="box-footer">
        <div class="form-actions">
            <a href="{{ route('administrator.permissions.index') }}" class="btn btn-warning"
               style="font-weight: bold">Back</a>
            <button type="reset" class="btn btn-default text-bold">Reset</button>
            <button type="submit" class="btn btn-primary text-bold">Save Changes</button>
        </div>
    </div>
</div>