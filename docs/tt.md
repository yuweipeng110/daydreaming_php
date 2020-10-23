/user/get-player-list	获取玩家列表（返回列表）
currentPage	当前页数
pageRecords	每页行数

列表行
id			玩家ID
nickname		昵称
sex			性别（0，女，1，男）
phone			电话号码
killerIntegral		杀手积分
detectiveIntegral	侦探积分
perpleIntegral		路人积分
totalIntegral		总积分
activeIntegral		可用积分
remark			备注
otime			注册时间


/user/add-player	添加玩家信息
storeId		门店ID
nickname	昵称
sex		性别（0，女，1，男）：可不填
phone		电话号码
remark		备注

/user/edit-player	修改玩家信息
playerId	玩家id
nickname	昵称
sex		性别（0，女，1，男）：可不填
phone		电话号码
remark		备注


創建門店是同時創業與綁定門店admin用戶

Business_Check_Store CheckStoreNameOnly 垃圾代码

Business_User_List SearchStoreList 更改代码