$(function(){
	// Customer add modal btn add click 
	$('#modal-customer-add').click(function(){
		$('#modal').modal('show').find('#modal-content').load($(this).attr('value'));		
		//console.log($(this).attr('value'));
	});
	
});
var tabIndexActived=1;
var tabIndexActivedHistory = [1];
var itemList =[];
var invoicesCheckOut = {};
//create  Invoice class, to save invoice
function Invoice(){
	this.id  = '';
	this.items = {};
	//
	this.addItem = function(item){
		var itemId = item.id;
		this.items[itemId] = item;
	};
	this.showItems = function(){
		return this.items;
	};
	this.getItemCount = function(){
		return Object.keys(this.items).length + 1;
	};
	this.updateItem = function(itemId,quantityValue,discountTypeValue,discountValue){		
		this.items[itemId].quantity = quantityValue;
		this.items[itemId].discountType = discountTypeValue;
		this.items[itemId].discount = discountValue;
	};
}

$(document).ready(function(){
	
	$('#btnCheckout').on('click',function(){
		console.log(invoicesCheckOut);
	});
	//
	$('#sale-item-list-1').on('change','tr td .sale_item_quantity',function(){
		var itemCountId =$(this).parents().parents().prev().prev().children();
		var priceElement = $(this).parents().parents().next().find($('.sale_item_price'));		
		var discountTypeElement = $(this).parents().parents().next().next().find($('.sale_item_discount_type'));
		var discountElement = $(this).parents().parents().next().next().find($('.sale_item_discount'));
		var totalPriceElement = $(this).parents().parents().next().next().next().find($('.sale_item_total'));	
		updateTotalPrice(itemCountId,priceElement,$(this),discountElement,discountTypeElement,totalPriceElement);
	});
	$('#sale-item-list-1').on('focusout','tr td .sale_item_price',function(){
		var itemCountId =  $(this).parent().prev().prev().prev().children();
		var quantityElement = $(this).parent().prev().find($('.sale_item_quantity'));
		var discountTypeElement = $(this).parent().next().find($('.sale_item_discount_type'));
		var discountElement =  $(this).parent().next().find($('.sale_item_discount'));
		var totalPriceElement =  $(this).parent().next().next().find($('.sale_item_total'));
		discountElement.autoNumeric('update', {'vMin':0,'vMax':$(this).autoNumeric('get')}); 	
		updateTotalPrice(itemCountId,$(this),quantityElement,discountElement,discountTypeElement,totalPriceElement);
	});
	$('#sale-item-list-1').on('switchChange.bootstrapSwitch','tr td .sale_item_discount_type',function(event,state){		
		// declare vairabe for each element;
		var itemCountId = $(this).parents().parents().parents().parents().parents().prev().prev().prev().prev().children();
		var priceElement = $(this).parents().parents().parents().parents().parents().prev().children();
		var quantityElement = $(this).parents().parents().parents().parents().parents().prev().prev().find($('.sale_item_quantity'));
		var discountElement = $(this).parents().parents().parents().parents().parents().find($('.sale_item_discount'));		
		var totalPriceElement = $(this).parents().parents().parents().parents().parents().next().find($('.sale_item_total'));				
		// update min max of autonumber for discount value
		if(state == true){
			discountElement.autoNumeric('update', {'vMin':0,'vMax':100}); 	
			discountElement.autoNumeric('set',0);
		}else{
			discountElement.autoNumeric('update', {'vMin':0,'vMax':priceElement.autoNumeric('get')}); 			
			discountElement.autoNumeric('set',0);
		}
		updateTotalPrice(itemCountId,priceElement,quantityElement,discountElement,$(this),totalPriceElement);
	});
	$('#sale-item-list-1').on('focusout','tr td .sale_item_discount',function(){
		var itemCountId  = $(this).parents().parents().prev().prev().prev().prev().children()
		var priceElement = $(this).parents().parents().prev().children();
		var quantityElement = $(this).parents().parents().prev().prev().find($('.sale_item_quantity'));
		var discountType = $(this).parent().find($('.sale_item_discount_type'));
		var totalPriceElement = $(this).parents().parents().next().find($('.sale_item_total'));
		updateTotalPrice(itemCountId,priceElement,quantityElement,$(this),discountType,totalPriceElement);
	});
	//
	$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
	  	var tabId = $(this).html();
	  	tabIndexActived = parseInt(tabId.slice(1));
	  	registerEventsForItem(tabIndexActived);
	})
	/* Register item event by dynamic*/
	function registerEventsForItem(tabIndex){
		// Check if tab aready show (same aready event registed)
		if(jQuery.inArray(tabIndexActived,tabIndexActivedHistory) == -1){
			// register event
			$('#sale-item-list-'+tabIndex).on('change','tr td .sale_item_quantity',function(){
				var itemCountId =$(this).parents().parents().prev().prev().children();
				var priceElement = $(this).parents().parents().next().find($('.sale_item_price'));		
				var discountTypeElement = $(this).parents().parents().next().next().find($('.sale_item_discount_type'));
				var discountElement = $(this).parents().parents().next().next().find($('.sale_item_discount'));
				var totalPriceElement = $(this).parents().parents().next().next().next().find($('.sale_item_total'));	
				updateTotalPrice(itemCountId,priceElement,$(this),discountElement,discountTypeElement,totalPriceElement);
			});
			$('#sale-item-list-'+tabIndex).on('focusout','tr td .sale_item_price',function(){
				var itemCountId =  $(this).parent().prev().prev().prev().children();
				var quantityElement = $(this).parent().prev().find($('.sale_item_quantity'));
				var discountTypeElement = $(this).parent().next().find($('.sale_item_discount_type'));
				var discountElement =  $(this).parent().next().find($('.sale_item_discount'));
				var totalPriceElement =  $(this).parent().next().next().find($('.sale_item_total'));
				discountElement.autoNumeric('update', {'vMin':0,'vMax':$(this).autoNumeric('get')}); 	
				updateTotalPrice(itemCountId,$(this),quantityElement,discountElement,discountTypeElement,totalPriceElement);
			});
			$('#sale-item-list-'+tabIndex).on('switchChange.bootstrapSwitch','tr td .sale_item_discount_type',function(event,state){		
				// declare vairabe for each element;
				var itemCountId = $(this).parents().parents().parents().parents().parents().prev().prev().prev().prev().children();
				var priceElement = $(this).parents().parents().parents().parents().parents().prev().children();
				var quantityElement = $(this).parents().parents().parents().parents().parents().prev().prev().find($('.sale_item_quantity'));
				var discountElement = $(this).parents().parents().parents().parents().parents().find($('.sale_item_discount'));		
				var totalPriceElement = $(this).parents().parents().parents().parents().parents().next().find($('.sale_item_total'));		
				//				
				if(state == true){
					discountElement.autoNumeric('update', {'vMin':0,'vMax':100}); 	
					discountElement.autoNumeric('set',0);
				}else{
					discountElement.autoNumeric('update', {'vMin':0,'vMax':priceElement.autoNumeric('get')}); 			
					discountElement.autoNumeric('set',0);
				}
				updateTotalPrice(itemCountId,priceElement,quantityElement,discountElement,$(this),totalPriceElement);
				
			});
			$('#sale-item-list-'+tabIndex).on('focusout','tr td .sale_item_discount',function(){
				var itemCountId  = $(this).parents().parents().prev().prev().prev().prev().children()
				var priceElement = $(this).parents().parents().prev().children();
				var quantityElement = $(this).parents().parents().prev().prev().find($('.sale_item_quantity'));
				var discountType = $(this).parent().find($('.sale_item_discount_type'));
				var totalPriceElement = $(this).parents().parents().next().find($('.sale_item_total'));
				updateTotalPrice(itemCountId,priceElement,quantityElement,$(this),discountType,totalPriceElement);
			});
			// add into history
			tabIndexActivedHistory.push(tabIndex);
		}		
	}
	/* Functions: caculate total price with input  */
	function updateTotalPrice(itemId,price,quantity,discount,discountType,outputHtml){
		var itemIdValue = parseInt(itemId.attr('value'));
		var priceValue = price.autoNumeric('get');
		var quantityValue = quantity.val();
		var discountValue = discount.autoNumeric('get');
		var discountTypeState = discountType.bootstrapSwitch('state');
		var totalPriceValue = 0;
		if(discountTypeState == true){
			totalPriceValue = quantityValue *  (priceValue - (priceValue * (discountValue / 100)));		
		}else{
			totalPriceValue =  quantityValue * (priceValue  - discountValue);
		}
		// Change out put html
		outputHtml.autoNumeric('set',totalPriceValue);
		console.log(totalPriceValue);
		invoicesCheckOut[tabIndexActived].updateItem(itemIdValue,quantityValue,discountTypeState,discountValue);
		
	}
});
// process items search autocomplate when selecte item
function onItemAutoComplateSelected(obj1,obj2){	
	
	if(invoicesCheckOut[tabIndexActived] == null){
		var invoice = new Invoice();
		invoice.id = tabIndexActived;
		invoicesCheckOut[tabIndexActived] = invoice;
	}
	//
	var item = {
		'id' : invoicesCheckOut[tabIndexActived].getItemCount(),
		'quantity' : 1,
		'product_id' : obj2.product_id,
		'price' : obj2.price,
		'discountType' : 'false',
		'discount' : 0,
	}	

	var insertRow2 = '<tr>'+
			'<td><input class= "sale_item_id" type="hidden" value="' + invoicesCheckOut[tabIndexActived].getItemCount() + '"/>' + invoicesCheckOut[tabIndexActived].getItemCount() + '</td>' +
			'<td>'+obj2.value+'</td>' +
			'<td style="width:100px"><input class="sale_item_quantity" type="text" value="1" name="input_item_quantity"></td>' +
			'<td style="width:150px"><input class="sale_item_price form-control" type="text" value="' + obj2.price +'"></td>' +
			'<td style="width:200px">' +
				'<div class="input-group">' + 
					'<span class="input-group-btn">' + 
						'<input class="sale_item_discount_type" type="checkbox" </td>' +
					'</span>' +
					'<input class="sale_item_discount form-control" type="text" value="0"</td>' + 					
				'</div>' +
			'<td><input class="sale_item_total form-control" type="text" disabled value="' + obj2.price +'"></td>' +
			'<td><input id="sale_item_delete" type="button" class="form-control" value="Text"></td>' +
		'</tr>';
	invoicesCheckOut[tabIndexActived].addItem(item);	
//	$('#sale-item-list tr').last().after(insertRow2);	
	$('#sale-item-list-' + tabIndexActived +' tr').last().after(insertRow2);	

	$('.sale_item_quantity').TouchSpin({
	    'verticalbuttons': true,
	    'min' : 1,
	    'max':99999,
	});		
	$(".sale_item_price").autoNumeric('init',{'vMin':0,'vMax':9999999999999});
	$(".sale_item_total").autoNumeric('init',{'vMin':0,'vMax':9999999999999});
	$(".sale_item_discount").autoNumeric('init',{'vMin':0,'vMax':obj2.price});
	$(".sale_item_discount_type").bootstrapSwitch({
		//'size':'small',
		'onText' : '<i class="fa fa-percent"></i>',
		'offText' : '<i class="fa fa-usd"></i>',
	});

	//setup int variable
	/*var productId = $("#sale_item_id_"+sale_item_count).val();
	var price = $("#sale_item_price_"+sale_item_count).val();	
	var totalPriceHtml = $("#sale_item_total_"+sale_item_count);
	var quantity = 1;
	var discountType = false;
	var discount = $("#sale_item_discount_"+sale_item_count).val();	
	var saleItemDiscountHtml = $("#sale_item_discount_"+sale_item_count);*/

	/*$("#sale_item_quantity_"+sale_item_count).TouchSpin({
	    'verticalbuttons': true,
	    'min' : 1,
	    'max':99999,
	});*/
/*	$("#sale_item_discount_"+sale_item_count).TouchSpin({
	    'verticalbuttons': true,
	    'min' : 0,
	    'max':price,
	    'forcestepdivisibility' : 'round',
	    'decimals' : 0,

	});*/
	/*$("#sale_item_total_"+sale_item_count).autoNumeric('init',{'vMin':0,'vMax':9999999999999});
	$("#sale_item_price_"+sale_item_count).autoNumeric('init',{'vMin':0,'vMax':9999999999999});
	$("#sale_item_discount_"+sale_item_count).autoNumeric('init',{'vMin':0,'vMax':price});
	$("#sale_item_discount_type_"+sale_item_count).bootstrapSwitch({
		//'size':'small',
		'onText' : '<i class="fa fa-percent"></i>',
		'offText' : '<i class="fa fa-usd"></i>',
	});*/


	/*-- Event proccessing for each input --*/
	//quantity changed event
/*	$("#sale_item_quantity_"+sale_item_count).on('change',function(){
		quantity = $(this).val();
		var idHtml = $(this).attr('id').split('_');
		var id = idHtml[idHtml.length -1];
		totalPriceCaculate(id,productId,price,quantity,discount,discountType,totalPriceHtml);
	});*/
	// price outfocus event
/*	$("#sale_item_price_"+sale_item_count).on('focusout',function(){
	    price = $(this).autoNumeric('get');	 
	   	var idHtml = $(this).attr('id').split('_');
		var id = idHtml[idHtml.length -1];
	    saleItemDiscountHtml.autoNumeric('update', {'vMin':0,'vMax':price}); 
	    totalPriceCaculate(id,productId,price,quantity,discount,discountType,totalPriceHtml);
	});*/
	// discout type change event
/*	$("#sale_item_discount_type_"+sale_item_count).on('switchChange.bootstrapSwitch',function(event,state){
		discountType = state;
		if(discountType == true){
			saleItemDiscountHtml.autoNumeric('update', {'vMin':0,'vMax':100}); 
			discount = 0;
		}else{
			saleItemDiscountHtml.autoNumeric('update', {'vMin':0,'vMax':price}); 
			discount =0;
			saleItemDiscountHtml.autoNumeric('set',discount); 
		}
		var idHtml = $(this).attr('id').split('_');
		var id = idHtml[idHtml.length -1];
		totalPriceCaculate(id,productId,price,quantity,discount,discountType,totalPriceHtml);
	})*/
	// discount value outfocus evnt
/*	$("#sale_item_discount_"+sale_item_count).on('change',function(){
		discount = $(this).autoNumeric('get');	
		var idHtml = $(this).attr('id').split('_');
		var id = idHtml[idHtml.length -1];
		totalPriceCaculate(id,productId,price,quantity,discount,discountType,totalPriceHtml);
	});*/

/*	$("#sale_item_delete_"+sale_item_count).on('click',function(){
	    console.log(total);
	});*/
	//totalPriceCaculate(sale_item_count,productId,price,quantity,discount,discountType,totalPriceHtml);

}



