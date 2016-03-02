/* last updated 11/2010 */


$(function(){
/* ============================================================== extend height of nav bar */
	var navheight=function(){
		$('#nav').css({height: $('#bgmid').height()-51});
	};
	var pagesize=function(){
		$('#nav').css({height: 100});
		var hfheight = 185;
		var dheight=($('#display').height()+60);
		var idheight=($('#idisplay').height()+60);
		var cdheight=($('#cdisplay').height()+60);
		var wheight=($(window).height());
		if($('#idisplay').length==1){
			if(idheight < wheight-hfheight){
				//alert('display smaller');
				$('#bgmid').css({height: ($(window).height()-hfheight)});
			}
		};
		if($('#cdisplay').length==1){
			if(cdheight < wheight-hfheight){
				//alert('display smaller');
				$('#bgmid').css({height: ($(window).height()-hfheight)});
			}
		};
		if($('#display').length==1){
			if(dheight < wheight-hfheight){
				//alert('display smaller');
				$('#bgmid').css({height: ($(window).height()-hfheight)});
			}
		};
		navheight();
	};
	var formresize=function(){
		$('#nav').css({height: 100});
		$('#bgmid').css({height: $('#display').height()+60});
		navheight();
	};
	pagesize();
	$(window).bind('resize', pagesize);
/* ========================================== use unit to get resident list on new wo form */
	$('#location').live('change', function(e){
		var loc=$('#location').val();
		$.ajax({
			url:'srp/getRequesters.php',
			type:'get',
			dataType: 'html',
			success: function(html){
				$('#requestByform .i').html(html);
				$('#requestByform').removeClass('hidden');
				$('#s1').removeClass('active');
				$('#s1').addClass('past');
				$('#s2').removeClass('future');
				$('#s2').addClass('active');
				$('#by').live('change', function(e){
					$('#requestform').removeClass('hidden');
					$('#s2').removeClass('active').addClass('past');
					$('#s3').removeClass('future').addClass('active');
					formresize();
					//alert("by change");
				});
			},
			data:{loc:loc}
		});
		navheight();
		return false;
	});
	
/* =================================================== add hidden fields to new wo form */
	$('#requestform').bind('submit', function(){
		$('#hiddenfields')
			.empty()
			.append('<input type="hidden" name="location" value="'+$('#location').val()+'" />')
			.append('<input type="hidden" name="by" value="'+$('#by').val()+'" />')
			.append($('#notify').clone())
			.append($('#enter').clone())
		;
		navheight();
	});
/* ====================================================== click to show groups on unit.php */
	$('#viewunit').bind('click', function(){
		$('#unit').removeClass('hidden');
		$('#viewunit').addClass('active');
		$('#lease').addClass('hidden');
		$('#viewlease').removeClass('active');
		$('#residents').addClass('hidden');
		$('#viewresidents').removeClass('active');
		$('#wo').addClass('hidden');
		$('#viewwo').removeClass('active');
		pagesize();
		return false;
	});
	$('#viewlease').bind('click', function(){
		$('#unit').addClass('hidden');
		$('#viewunit').removeClass('active');
		$('#lease').removeClass('hidden');
		$('#viewlease').addClass('active');
		$('#residents').addClass('hidden');
		$('#viewresidents').removeClass('active');
		$('#wo').addClass('hidden');
		$('#viewwo').removeClass('active');
		pagesize();
		return false;
	});
	$('#viewresidents').bind('click', function(){
		$('#unit').addClass('hidden');
		$('#viewunit').removeClass('active');
		$('#lease').addClass('hidden');
		$('#viewlease').removeClass('active');
		$('#residents').removeClass('hidden');
		$('#viewresidents').addClass('active');
		$('#wo').addClass('hidden');
		$('#viewwo').removeClass('active');
		pagesize();
		return false;
	});
	$('#viewwo').bind('click', function(){
		$('#unit').addClass('hidden');
		$('#viewunit').removeClass('active');
		$('#lease').addClass('hidden');
		$('#viewlease').removeClass('active');
		$('#residents').addClass('hidden');
		$('#viewresidents').removeClass('active');
		$('#wo').removeClass('hidden');
		$('#viewwo').addClass('active');
		pagesize();
		return false;
	});
/* ====================================================== gives scheduled date box on new wo form */
	$('#status').live('change', function(e){
		if($('#status').val()==3){
			if($('#sstatus').hasClass('hidden')){
				$('#sstatus').removeClass('hidden');
			}
		}
		if($('#status').val()==4){
			if($('#cstatus').hasClass('hidden')){
				$('#cstatus').removeClass('hidden');
			}
		}
		navheight();
	});
	$('#rpage').live('change', function(e){
		$('.sortoptions').empty();
		var page=$('#rpage').val();
		if(page=="wo"){
			$.ajax({
				url:'srp/getWoSortBy.php',
				dataType: 'html',
				success: function(html){
					$('.sortoptions').html(html);
					$('.sortoptions').removeClass('hidden');
					$('#sort1 .opt .sortSelect').live('change', function(e){
						$('#sort1 .optData').empty();
						var sort=$('#sort1 .sortSelect').val();
						if(sort!="none"){
							if(sort=="date"){
								$('#sort1 .optData').append('<input type="text" name="date" id="date" value="YYYY/MM/DD" />');
								pagesize();
							}else if(sort=="unit"){
								$.ajax({
									url:'srp/getUnitOptions.php',
									dataType:'html',
									success:function(html){
										$('#sort1 .optData').append(html).wrapInner('<select name="unit"></select>');
										pagesize();
									}
								});
							}else if(sort=="status"){
								$.ajax({
									url:'srp/getStatusOptions.php',
									dataType:'html',
									success:function(html){
										$('#sort1 .optData').append(html).wrapInner('<select name="status"></select>');
										pagesize();
									}
								});
							}
						}else{
							$('#sort1 .optData').empty();
						}
						formresize();
					});
					pagesize();
				},
			});
		}else if(page=="unit"){
			$('.sortoptions').empty();
			$.ajax({
				url:'srp/getUnitSortBy.php',
				dataType: 'html',
				success: function(html){
					$('.sortoptions').html(html);
					$('.sortoptions').removeClass('hidden');
					pagesize();
				},
			});
		}else if(page=="lease"){
			$('.sortoptions').empty();
			$.ajax({
				url:'srp/getLeaseSortBy.php',
				dataType: 'html',
				success: function(html){
					$('.sortoptions').html(html);
					$('.sortoptions').removeClass('hidden');
					pagesize();
				},
			});
		}else if(page=="res"){
			
		}
		pagesize();
		return false;
	});
	$('#reportbtn').bind('submit', function(){
		if($('#rpage').val()=="wo"){
			//var sortby==$('#woSelect').val();
		}
		$.ajax({
			url:'srp/reportData.php',
			type:'get',
			dataType: 'html',
			success: function(html){
				$('#reportDisplay').html(html);
				$('#reportDisplay').removeClass('hidden');
				pagesize();
			},
			data:{loc:loc}
		});
		return false;
	});
});