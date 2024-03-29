@extends('layouts.app')
@section('title', '收货地址列表')

@section('content')
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">收货地址列表<a href="{{ route('user_addresses.create') }}" class="pull-right">新增收货地址</a>
                </div>
                <div class="panel-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>收货人</th>
                            <th>地址</th>
                            <th>邮编</th>
                            <th>电话</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($addresses)>0)
                            @foreach($addresses as $address)
                                <tr>
                                    <td>{{ $address->contact_name }}</td>
                                    <td>{{ $address->full_address }}</td>
                                    <td>{{ $address->zip }}</td>
                                    <td>{{ $address->contact_phone }}</td>
                                    <td>
                                        <a href="{{ route('user_addresses.edit', $address) }}"
                                           class="btn btn-primary">修改</a>
                                        <!-- 把之前删除按钮的表单替换成这个按钮，data-id 属性保存了这个地址的 id，在 js 里会用到 -->
                                        <button class="btn btn-danger btn-del-address" type="button"
                                                data-id="{{ $address->id }}">删除
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td class="text-center" colspan="5">
                                    <a class="btn btn-primary" href="{{ route('user_addresses.create')}}">
                                        还没有收货地址请添加收货地址哦！
                                    </a>
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scriptsAfterJs')
    <script>
        $(() => {
            // console.log($('.btn-del-address').data('id'));
            //删除按钮点击事件
            $('.btn-del-address').click(function () {
                //获取按钮上data-id属性的值,也就是地址的ID
                let id = $(this).data('id');
                console.log(id);
                swal({
                    title: '确定要删除该地址?',
                    icon: 'warning',
                    buttons: ['取消', '确定'],
                    dangerMode: true,
                }).then((willDelete) => {//用户点击按钮会触发这个回调函数
                    //用户点击确定willDelete值为true，否则为false
                    //用户点击了取消，啥也不做
                    if (!willDelete) {
                        return;
                    }
                    //调用删除接口，用ID来拼接出请求的url
                    axios.delete('user_addresses/' + id)
                        .then(() => {
                            //请求成功之后重新加载页面
                            location.reload();
                        })
                });
                return false;
            });
        });
    </script>
@stop