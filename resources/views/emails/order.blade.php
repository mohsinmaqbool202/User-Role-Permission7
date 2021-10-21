<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
  <table width="700px" border="0" cellpadding="0" cellspacing="0">
  	<tr><td>&nbsp;</td></tr>
  	<tr><td><img src="{{ asset('images/frontend_images/home/logo.png') }}"></td></tr>
  	<tr><td>&nbsp;</td></tr>
  	<tr><td>Hello {{ $name }},</td></tr>
  	<tr><td>&nbsp;</td></tr>
  	<tr><td>Thank you for shopping with us, your order details are as below:-</td></tr>
  	<tr><td>&nbsp;</td></tr>
  	<tr><td>Order NO: {{ $order_id }}</td></tr>
  	<tr><td>&nbsp;</td></tr>
  	<tr><td>
  			<table width="95%" cellpadding="5" cellspacing="5" bgcolor="#f7f4f4">
  				<tr bgcolor="#cccccc">
  					<td>Product Name</td>
  					<td>Product Code</td>
  					<td>Size</td>
  					<td>Color</td>
  					<td>Quantity</td>
  					<td>Unit Price</td>
  				</tr>
  				@foreach($orderDetail->orders as $product)
  				<tr>
  					<td>{{ $product->cart->product->name }}</td>
  					<td>{{ $product->cart->product->code }}</td>
  					<td>{{ $product->cart->product->size }}</td>
  					<td>{{ $product->cart->product->color }}</td>
  					<td>{{ $product->cart->quantity }}</td>
  					<td>{{ $product->cart->product->price }}</td>
  				</tr>
  				@endforeach
  				<tr>
  					<td colspan="5" align="right">Shipping Charges</td>
  					<td>PKR:00</td>
  				</tr>
  				<tr>
  					<td colspan="5" align="right">Coupon Discont</td>
  					<td>PKR:00</td>
  				</tr><tr>
  					<td colspan="5" align="right">Grand Total</td>
  					<td>PKR:{{ $orderDetail->grand_total }}</td>
  				</tr>
  			</table>
  	</td></tr>
  	<tr><td>
  		<table width="100%">
				<tr>
					<td width="50%">
						<table>
							 <tr>
							 	<td><strong>Bill To</strong></td>
							 </tr>
							 <tr>
							 	<td>{{ $customer->name }}</td>
							 </tr>
							 <tr>
							 	<td>{{ $customer->address }}</td>
							 </tr>
							 <tr>
							 	<td>{{ $customer->city }}</td>
							 </tr>
							 <tr>
							 	<td>{{ $customer->state }}</td>
							 </tr>
							 <tr>
							 	<td>{{ $customer->pincode }}</td>
							 </tr>
							 <tr>
							 	<td>{{ $customer->mobile }}</td>
							 </tr>
						</table>
					</td>
					<td width="50%">
						<table>
							 <tr>
							 	<td><strong>Ship To</strong></td>
							 </tr>
							 <tr>
							 	<td>{{ $customer->deliveryAddress->name }}</td>
							 </tr>
							 <tr>
							 	<td>{{ $customer->deliveryAddress->address }}</td>
							 </tr>
							 <tr>
							 	<td>{{ $customer->deliveryAddress->city }}</td>
							 </tr>
							 <tr>
							 	<td>{{ $customer->deliveryAddress->state }}</td>
							 </tr>
							 <tr>
							 	<td>{{ $customer->deliveryAddress->pincode }}</td>
							 </tr>
							 <tr>
							 	<td>{{ $customer->deliveryAddress->mobile }}</td>
							 </tr>
						</table>
					</td>
				</tr>  			
  		</table>
  	</td></tr>
  	<tr><td>&nbsp;</td></tr>
  	<tr><td>For any query you contact us at <a href="mailto:mohsinmaqbool333@gmail.com">mohsinmaqbool451@gmail.com</a></td></tr>
  	<tr><td>&nbsp;</td></tr>
  	<tr><td>Regards: Team E-Sop</td></tr>
  	<tr><td>&nbsp;</td></tr>
  </table>
</body>
</html>