@extends('admin.alert')

@section('content')
<!-- 选出栏目 -->
<ul class="clearfix">
	@foreach($list as $a)
	<li class="mr10 pull-left"><label class="radio-inline"><input type="checkbox" name="tid[]" class="input-radio" value="{{ $a->id }}"> {{ $a->name }}</label></li>
	@endforeach
</ul>
@endsection