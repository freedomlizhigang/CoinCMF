@extends('admin.right')

@section('content')
<form action="javascript:ajax_submit();" method="post" id="form_ajax">
	{{ csrf_field() }}
	<!-- 提交返回用的url参数 -->
	<input type="hidden" name="ref" value="{!! $ref !!}">
	
	<table class="table table-striped">
	   

	    <tr>
	        <td class="td_left">素材标题：</td>
	        <td>
	            <input type="text" name="data[name]" value="{{ $name }}" class="form-control input-sm">
	            <p class="input-info"><span class="color_red">*</span>不超过255字符</p>
	        </td>
	    </tr>
	    
	   
	    <tr>
	        <td></td>
	        <td>
	            <div class="btn-group">
	                <button type="reset" name="reset" class="btn btn-xs btn-warning">重填</button>
	                <div onclick='ajax_submit_form("form_ajax","{{ url('/console/wxart/edit',['id'=>$id]) }}")' name="dosubmit" class="btn btn-xs btn-info">提交</div>
	            </div>
	        </td>
	    </tr>
	</table>

</form>

@endsection