$(function(){
	if(!window.localStorage){
        alert("浏览器不支持localstorage");
        return false;
    }else{
        storage=window.localStorage;
        storage.page=1;
    }
	// 科室切换
	$(".ks-mainR ul").eq(0).show()
	$(".ks-mainL ul li").click(function() {
		var index = $(this).index();
		$(this).addClass("active").siblings().removeClass('active');
		$(".ks-mainR ul").hide();
		$(".ks-mainR ul").eq(index).show();
	})

	// 选择医生切换1
	// $(".ystitle-tab span").click(function() {
	// 	var index = $(this).index();
	// 	$(this).addClass("active").siblings().removeClass('active');

	// 	$(".ghyysj").removeClass('hide');

	// 	if (index == 0) {
	// 		$(".ghyysj").show()
	// 		$(".ysmain-tab").css({
	// 			"height": "calc(100% - 105px)"
	// 		})
	// 	} else {
	// 		$(".ghyysj").hide()
	// 		$(".ysmain-tab").css({
	// 			"height": "calc(100% - 52px)"
	// 		})
	// 	}
	// })

	// 选择切换医生2
	$(".ghyysj-con div").click(function() {
		$(this).addClass("active").siblings().removeClass('active');
		storage.page=1;
		getListData();
		// $(this).addClass("active").siblings().removeClass('active');
		// if(ind==0){
		// 	curPageData=curPageData.slice(0,5)
		// 	// console.log(curPageData)
		// 	for (var i = 0; i < curPageData.length; i++) {
		// 		listData.push(curPageData[i]);
		// 	}
		// }
	})

	//预约挂号弹窗
	var str = '<ul class="tcnr"><li>1、挂号成功后不用取号,凭公众号推送的"挂单号"可直接就诊</li>' +
		'<li>2、当天号放号时间为上午07:15-11:30,下午14:00-17:00,预约号放号时间为提前7天的16:00,最多可预约7天号源</li>' +
		'<li>3、每人每天限挂号3个,每个科室限挂号1次,每月最多10次</li>' +
		'<li>4、预约挂号可提前1天在"导诊""挂号记录"中取消;挂号后当天不就诊不退号,医院不再安排就诊及退费</li></ul>';
	$(".ghsys1").click(function(e) {
		e.preventDefault()
		url = $(this).attr('href');
		// event.preventDefault ? event.preventDefault() : (event.returnValue = false);
		layer.open({
			title: ["挂号须知", "font-size:22px;margin:20px 0 0 0;"],
			style: 'width:70%;',
			content: str,
			btn: ["确定", "取消"],
			yes: function() {
				window.location.href = url;
			},
			no: function(index) {
				layer.close(index)
			}
		})
	})



	// 挂号 时间段
	$("#ghSjd li").click(function() {
		$(this).addClass("ghsjd-active").siblings().removeClass("ghsjd-active");
	})

	var flag = true;
	$(".ghsjd-jzrjt").click(function() {
		if(flag){
			$(".ghsjd-jzrjt").css({
				"background": "url(../img/arrow-down.png) no-repeat right",
	 			"background-size": "20px"
	 		})
			$("#appCon").show()
			flag=false
			
		}else{
			$(".ghsjd-jzrjt").css({
	 			"background": "url(../img/arrow-right1.png) no-repeat right",
	 			"background-size": "20px"
	 		})
			$("#appCon").hide()
			flag=true
		}
	
	})
	
	$("#appCon .appstr").click(function() {
		$(this).addClass("addappendactive").siblings().removeClass("addappendactive");
		$("#appCon").hide()
		$(".ghsjd-jzrjt").css({
			"background": "url(../img/arrow-right1.png) no-repeat right",
			"background-size": "20px"
		})
		
		var jzrxxName=$(this).attr('name')
		
		$(".ghsjd-jzrjt").html(jzrxxName)
		flag=true
	})
	

	var flag2 = true;

	$(".html1-tab1 div").click(function() {
		var index = $(this).index();
		$(this).addClass("html1-active").siblings().removeClass("html1-active");

		$(".html1-tab2").children("div").hide();
		$(".html1-tab2").children("div").eq(index).show();

	})



	
})