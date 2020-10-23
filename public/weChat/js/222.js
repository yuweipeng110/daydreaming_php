$(function(){
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
	})
	
	
	//预约挂号弹窗
	var str = '<ul class="tcnr"><li>1、挂号成功后不用取号,凭公众号推送的"挂单号"可直接就诊</li>' +
		'<li>2、当天号放号时间为上午07:15-11:30,下午14:00-17:00,预约号放号时间为提前7天的16:00,最多可预约7天号源</li>' +
		'<li>3、每人每天限挂号3个,每个科室限挂号1次,每月最多10次</li>' +
		'<li>4、预约挂号可提前1天在"导诊""挂号记录"中取消;挂号后当天不就诊不退号,医院不再安排就诊及退费</li></ul>';
	$(".ghsys1").click(function(e) {
		e.preventDefault()
		// event.preventDefault ? event.preventDefault() : (event.returnValue = false);
		layer.open({
			title: ["挂号须知", "font-size:22px;margin:20px 0 0 0;"],
			style: 'width:70%;',
			content: str,
			btn: ["确定", "取消"],
			yes: function() {
				window.location.href = "gh_yszy.html"
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
		if (flag) {
			$(".ghsjd-jzrjt").css({
				"background": "url(./img/arrow-down.png) no-repeat right",
				"background-size": "20px"
			})
	
			$("#appCon").show()
			$("#appCon .appstr").click(function() {
				$(this).addClass("addappendactive").siblings().removeClass("addappendactive");
	
			})
	
			flag = false;
		} else {
			$(".ghsjd-jzrjt").css({
				"background": "url(./img/arrow-right1.png) no-repeat right",
				"background-size": "20px"
			})
	
			$("#appCon").hide()
	
	
			flag = true;
		}
	
	})
	
	
	// 我的挂号
	var jzrqhStr =
		'<ul class="wdgh-qhjzr">' +
		'<li class="wdgh-qhjzr-active">' +
		'<span>居民健康卡/周杰/43102519870</span>' +
		'</li>' +
		'<li>' +
		'<span>居民健康卡/王伟/43102519870</span>' +
		'</li>' +
		'</ul>';
	
	$(".wdgh-xzk").click(function() {
		$(".wdgh-xzk").css({
			"background": "url(./img/arrow-down.png) no-repeat 95%",
			"background-size": "20px",
			"background-color": "#fff"
		})
	
	
		var index = layer.open({
			content: jzrqhStr,
			style: "position:fixed; left:0; top:45px;width:100%; ",
			shadeClose: false,
			shade: 'background-color: rgba(0,0,0,.2)',
			success: function() {
				$(".wdgh-qhjzr li").click(function() {
					$(this).addClass("wdgh-qhjzr-active").siblings().removeClass("wdgh-qhjzr-active");
					layer.close(index)
					var liHtml = $(this).children('span').html();
					$(".wdgh-xzk").children('span').html(liHtml);
				})
			},
			end: function() {
				$(".wdgh-xzk").css({
					"background": "url(./img/arrow-right1.png) no-repeat 95%",
					"background-size": "20px",
					"background-color": "#fff"
				})
			}
		})
	
	})
	
	var flag2 = true;
	// 我的检验检查
	$(".wdjyjc-tab1 span").click(function() {
		var index = $(this).index();
		$(this).addClass("wdjyjc-active").siblings().removeClass("wdjyjc-active");
	
		$(".wdjyjc-tab2").children("div").hide();
		$(".wdjyjc-tab2").children("div").eq(index).show();
	
	})
	
	$(".html1-tab1 div").click(function() {
		var index = $(this).index();
		$(this).addClass("html1-active").siblings().removeClass("html1-active");
	
		$(".html1-tab2").children("div").hide();
		$(".html1-tab2").children("div").eq(index).show();
	
	})
	
	
	var mescroll = new MeScroll("mescroll", { //第一个参数"mescroll"对应上面布局结构div的id (1.3.5版本支持传入dom对象)
		//如果您的下拉刷新是重置列表数据,那么down完全可以不用配置,具体用法参考第一个基础案例
		//解析: down.callback默认调用mescroll.resetUpScroll(),而resetUpScroll会将page.num=1,再触发up.callback
		down: {
			callback: downCallback //下拉刷新的回调,别写成downCallback(),多了括号就自动执行方法了
		},
		up: {
			callback: upCallback, //上拉加载的回调
			//以下是一些常用的配置,当然不写也可以的.
			page: {
				num: 0, //当前页 默认0,回调之前会加1; 即callback(page)会从1开始
				size: 10 //每页数据条数,默认10
			},
			htmlNodata: '<p class="upwarp-nodata">-- END --</p>',
			noMoreSize: 5, //如果列表已无数据,可设置列表的总数量要大于5才显示无更多数据;
					// 避免列表数据过少(比如只有一条数据),显示无更多数据会不好看
					// 这就是为什么无更多数据有时候不显示的原因.
			toTop: {
				//回到顶部按钮
				src: "../img/mescroll-totop.png", //图片路径,默认null,支持网络图
				offset: 1000 //列表滚动1000px才显示回到顶部按钮	
			},
			empty: {
				//列表第一页无任何数据时,显示的空提示布局; 需配置warpId才显示
				warpId:	"xxid", //父布局的id (1.3.5版本支持传入dom元素)
				icon: "../img/mescroll-empty.png", //图标,默认null,支持网络图
				tip: "暂无相关数据~" //提示
			},
			lazyLoad: {
					use: true, // 是否开启懒加载,默认false
					attr: 'imgurl' // 标签中网络图的属性名 : <img imgurl='网络图  src='占位图''/>
				}
		}
	});
	
	/*初始化菜单*/
	var pdType = 0; //全部商品0; 奶粉1; 面膜2; 图书3;
	$(".ystitle-tab span").click(function() {
		var i = $(this).attr("i");
		if (pdType != i) {
			
			//更改列表条件
			pdType = i;
			$(".ystitle-tab .active").removeClass("active");
			$(this).addClass("active");
			//重置列表数据
			mescroll.resetUpScroll();
			//隐藏回到顶部按钮
			mescroll.hideTopBtn();
		}
		if(i==0){
			$(".ghyysj").show()
		}else{
			$(".ghyysj").hide()
		}
	})
	
	//下拉刷新的回调
			function downCallback() {
				$.ajax({
					url: 'xxxxxx',
					success: function(data) {
						//联网成功的回调,隐藏下拉刷新的状态;
						mescroll.endSuccess(); //无参. 注意结束下拉刷新是无参的
						//设置数据
						//setXxxx(data);//自行实现 TODO
					},
					error: function(data) {
						//联网失败的回调,隐藏下拉刷新的状态
						mescroll.endErr();
					}
				});
			}
			
			//上拉加载的回调 page = {num:1, size:10}; num:当前页 默认从1开始, size:每页数据条数,默认10
			function upCallback(page) {
				var pageNum = page.num; // 页码, 默认从1开始 如何修改从0开始 ?
				var pageSize = page.size; // 页长, 默认每页10条
				$.ajax({
					url: './res/aaa.json?num=' + pageNum + "&size=" + pageSize,
					success: function(data) {
						var curPageData = data.a; // 接口返回的当前页数据列表
						var totalPage = data.ys; // 接口返回的总页数 (比如列表有26个数据,每页10条,共3页; 则totalPage值为3)
						var totalSize = data.zs; // 接口返回的总数据量(比如列表有26个数据,每页10条,共3页; 则totalSize值为26)
						var hasNext = data.hn; // 接口返回的是否有下一页 (true/false)
						
						//联网成功的回调,隐藏下拉刷新和上拉加载的状态;
						//mescroll会根据传的参数,自动判断列表如果无任何数据,则提示空,显示empty配置的内容;
						//列表如果无下一页数据,则提示无更多数据,(注意noMoreSize的配置)
						
						//方法一(推荐): 后台接口有返回列表的总页数 totalPage
						//必传参数(当前页的数据个数, 总页数)
						mescroll.endByPage(curPageData.length, totalPage);
								
						//方法二(推荐): 后台接口有返回列表的总数据量 totalSize
						//必传参数(当前页的数据个数, 总数据量)
						mescroll.endBySize(curPageData.length, totalSize);
								
						//方法三(推荐): 您有其他方式知道是否有下一页 hasNext
						//必传参数(当前页的数据个数, 是否有下一页true/false)
						mescroll.endSuccess(curPageData.length, hasNext);
								
						//方法四 (不推荐),会存在一个小问题:比如列表共有20条数据,每页加载10条,共2页.
						//如果只根据当前页的数据个数判断,则需翻到第三页才会知道无更多数据
						//如果传了hasNext,则翻到第二页即可显示无更多数据.
						//mescroll.endSuccess(curPageData.length);
						
						//curPageData.length必传的原因:
						// 1. 使配置的noMoreSize 和 empty生效
						// 2. 判断是否有下一页的首要依据: 
						//    当传的值小于page.size时(说明不满页了),则一定会认为无更多数据;
						//    比传入的totalPage, totalSize, hasNext具有更高的判断优先级;
						// 3. 当传的值等于page.size时,才会取totalPage, totalSize, hasNext判断是否有下一页
						// 传totalPage, totalSize, hasNext目的是避免方法四描述的小问题
						
						//设置列表数据
						setListData(curPageData);//自行实现 TODO
					},
					error: function(e) {
						//联网失败的回调,隐藏下拉刷新和上拉加载的状态
						mescroll.endErr();
					}
				});
			}
	
	/*设置列表数据*/
	function setListData(curPageData) {
	// function setListData() {
		var listDom = document.getElementById("dataList");
		for (var i = 0; i < curPageData.length; i++) {
			var pd = curPageData[i];
	
	
			var str = '<div class="item">'
			str += '<div class="itemL">'
			str += '<div class="img-box">'
			str += '<img src="'+pd.pdImg+'"  width="50px">'
			str += '</div>'
			str += '<div class="xj-box">'
			str += '<span>★</span>'
			str += '<span>5.0</span>'
			str += '</div>'
			str += '</div>'
			str += '<div class="itemR">'
			str += '<div class="itemR-div1 clear">'
			str += '<div class="floatL">'
	
			str += '<span class="ysmz">金琳晓</span>'
			str += '<span class="yszz">医师</span>'
			str += '<span class="ghfy">挂号费：15元</span>'
			str += '</div>'
			str += '<div class="floatR">'
	
			str += '<a href="gh_yszy.html" class="ghsys1">挂号</a>'
			str += '</div>'
			str += '</div>'
			str += '<div class="itemR-div2">'
	
			str += '<p>擅长：骨折 骨关节炎 腰椎间盘突出 颈椎病颈椎病颈椎病颈椎病</p>'
			str += '</div>'
			str += '<div class="itemR-div3">'
			str += '<span>骨折类优秀医生</span>'
			str += '<span>周好评第三</span>'
			str += '</div>'
			str += '</div>'
			str += '</div>'
		
			var liDom = document.createElement("li");
			liDom.innerHTML = str;
			listDom.appendChild(liDom);
		}
	}
	
	
})