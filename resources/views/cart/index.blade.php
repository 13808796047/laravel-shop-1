@extends('layouts.app')

@section('title', '购物车')

@section('content')
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">我的购物车</div>
                <div class="panel-body">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th><input type="checkbox" id="select-all"></th>
                            <th>商品信息</th>
                            <th>单价</th>
                            <th>数量</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody class="product_list">
                        @foreach($cartItems as $item)
                            <tr data-id="{{ $item->productSku->id }}">
                                <td>
                                    <input type="checkbox" name="select"
                                           value="{{ $item->productSku->id }}" {{ $item->productSku->product->on_sale ? 'checked' : 'disabled' }}>
                                </td>
                                <td class="product_info">
                                    <div class="preview">
                                        <a target="_blank"
                                           href="{{ route('products.show', [$item->productSku->product_id]) }}">
                                            <img src="{{ $item->productSku->product->image_url }}">
                                        </a>
                                    </div>
                                    <div @if(!$item->productSku->product->on_sale) class="not_on_sale" @endif>
                                      <span class="product_title">
                                        <a target="_blank"
                                           href="{{ route('products.show', [$item->productSku->product_id]) }}">{{ $item->productSku->product->title }}</a>
                                      </span>
                                        <span class="sku_title">{{ $item->productSku->title }}</span>
                                        @if(!$item->productSku->product->on_sale)
                                            <span class="warning">该商品已下架</span>
                                        @endif
                                    </div>
                                </td>
                                <td><span class="price">￥{{ $item->productSku->price }}</span></td>
                                <td>
                                    <input type="text" class="form-control input-sm amount"
                                           @if(!$item->productSku->product->on_sale) disabled @endif name="amount"
                                           value="{{ $item->amount }}">
                                </td>
                                <td>
                                    <button class="btn btn-xs btn-danger btn-remove">移除</button>
                                </td>
                            </tr>
                        @endforeach
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
            //监听移除按钮事件
            $('.btn-remove').click(function () {
                //$(this)可以获取到当前点击的移除按钮的jQuery对象
                //closest()方法可以获得到匹配选择器的第一个祖元素，在这里就是当前点击移除按钮上的<tr>标签
                //data('id')方法可以获取到我们这前设置的data-id属性的值，也就是对应的SKU id
                let id = $(this).closest('tr').data('id');
                swal({
                    title: '确定要将该商品移除?',
                    icon: 'warning',
                    buttons: ['取消', '确定'],
                    dangerMode: true,
                }).then((willDelete) => {
                    //用户点击确定按钮，willDelete的值就会是true，否则为false
                    if (!willDelete) {
                        return;
                    } else {
                        axios.delete('/cart/' + id)
                            .then(() => {
                                location.reload();
                            })
                    }
                })
                return false;
            });
            //监听全选/取消全选 单选框的变更事件
            $('#select-all').change(function(){
                //获取单选框的选中状态
                //prop()方法可以知道标签中是否包含某个属性，当单选框被勾选时，对应的标签就会新增一个checked属性
                let checked = $(this).prop('checked');
                //console.log(checked);
                //获得所有name=select并且不带有disabled属性的勾选框会被选中，因此我们需要加上:not([disabled])这个条件
                $('input[name=select][type=checkbox]:not([disabled])').each(function(){
                    //将其勾选状态设为与目标单选框一致
                    $(this).prop('checked',checked);
                })
            });
        });
    </script>
@stop