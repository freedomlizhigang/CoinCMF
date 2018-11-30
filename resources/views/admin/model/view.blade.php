@extends('admin.right')

@section('content')
<table class="table table-striped">
    @foreach($info->fields as $f)
        @include('fields.'.$f->type,['field'=>$f->field_name,'title'=>$f->title,'tips'=>$f->tips,'option'=>json_decode($f->option),'required_flag'=>$f->required_flag])
    @endforeach
</table>
@endsection