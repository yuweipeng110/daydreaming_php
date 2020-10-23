// $.fn.ghostsf_serialize = function () {
// 	var a = this.serializeArray();
// 	var $radio = $('input[type=radio],input[type=checkbox]', this);
// 	var temp = {};
// 	$.each($radio, function () {
// 		if (!temp.hasOwnProperty(this.name)) {
// 			if ($("input[name='" + this.name + "']:checked").length == 0) {
// 				temp[this.name] = "";
// 				a.push({ name: this.name, value: "" });
// 			}
// 		}
// 	});
// 	//console.log(a);
// 	return jQuery.param(a);
// };


// $.fn.serializeObject = function () {
// 	var ct = this.serializeArray();
// 	var obj = {};
// 	$.each(ct, function () {
// 		if (obj[this.name] !== undefined) {
// 			if (!obj[this.name].push) {
// 				obj[this.name] = [obj[this.name]];
// 			}
// 			obj[this.name].push(this.value || "");
// 		} else {
// 			obj[this.name] = this.value || "";
// 		}
// 	});
// 	return obj;
// };


layui.use('form', function () {
	var form = layui.form;
	var layer = layui.layer;

	form.on('submit(*)', function (data) {

		var formdata = data.field;
		// console.log(formdata)
		var nameReg = /[A-Za-z0-9_\-\u4e00-\u9fa5]+/;
		var sfzReg = /(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/;
		var sjReg = /0?(13|14|15|17|18|19)[0-9]{9}/;
		var yzmReg = /([0-9]{4})/;
		var checkProv = function (val) {
			var pattern = /^[1-9][0-9]/;
			var provs = { 11: "北京", 12: "天津", 13: "河北", 14: "山西", 15: "内蒙古", 21: "辽宁", 22: "吉林", 23: "黑龙江 ", 31: "上海", 32: "江苏", 33: "浙江", 34: "安徽", 35: "福建", 36: "江西", 37: "山东", 41: "河南", 42: "湖北 ", 43: "湖南", 44: "广东", 45: "广西", 46: "海南", 50: "重庆", 51: "四川", 52: "贵州", 53: "云南", 54: "西藏 ", 61: "陕西", 62: "甘肃", 63: "青海", 64: "宁夏", 65: "新疆", 71: "台湾", 81: "香港", 82: "澳门" };
			if (pattern.test(val)) {
				if (provs[val]) {
					return true;
				}
			}
			return false;
		}
		// if (formdata.nickname == "") {
		// 	layer.msg('用户名不能为空');
		// 	return false;
		// } else if (!nameReg.test(formdata.nickname)) {
		// 	layer.msg('用户名输入错误');
		// 	return false;
		// }

		// if (formdata.idcard == "") {
		// 	layer.msg('身份证不能为空');
		// 	return false;
		// } else if (!sfzReg.test(formdata.idcard)) {
		// 	layer.msg('身份证输入错误');
		// 	return false;
		// }
		// // console.log(checkProv(formdata.sfznumber))
		// if (formdata.phone == "") {
		// 	layer.msg('手机不能为空');
		// 	return false;
		// } else if (!sjReg.test(formdata.phone)) {
		// 	layer.msg('手机号输入错误');
		// 	return false;
		// }
		// if (formdata.cap == "") {
		// 	layer.msg('验证码不能为空');
		// 	return false;
		// } else if (!yzmReg.test(formdata.cap)) {
		// 	layer.msg('验证码输入错误');
		// 	return false;
		// }

		// if (formdata.agree == "") {
		// 	layer.msg('请同意用户协议');
		// 	return false;
		// }
		return true;
	});

});
