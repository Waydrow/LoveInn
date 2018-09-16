# 爱心驿站APP接口

>   说明:
>
>   1.  下列所有接口的访问前缀为 https://qcloud.waydrow.com/LoveInn/index.php/Home/App/
>
>   2. 数据库图片存放格式为 `/LoveInn/Public/Uploads/2017-02-04/5895f417cca84.jpg`
>
>       访问图片需加前缀 https://qcloud.waydrow.com
>
>       注意: 前缀最后没有 `/`

### 迭代记录

| 版本   | 时间         | 说明                | 修改者     |
| ---- | ---------- | ----------------- | ------- |
| v1.0 | 2017.02.02 | 初始化               | waydrow |
| v1.1 | 2017.02.07 | 活动列表及信息中添加photo字段 | waydrow |
| v1.2 | 2017.02.16 | 添加报名及获取认证状态接口     | waydrow |
| v1.3 | 2017.04.27 | 添加获取历史活动信息接口      | waydrow |

## 1. 登录

### 1.1 interface

`login`

### 1.2 method

Post

### 1.3 send

-   username
-   password

### 1.4 return

-   user_id: 登录成功
-   0: 失败

## 2. 注册

### 2.1 interface

`register`

### 2.2 method

get/post

### 2.3 send

-   username
-   password

### 2.4 return

-   0: 用户名重复
-   user_id: 成功

## 3.获取活动列表

### 3.1 interface

`getActivityList`

### 3.2 method

get

### 3.3 return

example:

```json
[
  {
    "id": "6",
    "name": "这是活动1",
    "summary": "没有活动简介",
    "photo": "/LoveInn/Public/Uploads/2017-02-07/5898a0249cb29.jpg",
    "begintime": "2017-02-07 00:00:00"
  },
  {
    "id": "7",
    "name": "这是活动2",
    "summary": "这是简介2",
    "photo": "/LoveInn/Public/Uploads/2017-02-07/5898a0840c81a.jpg",
    "begintime": "2017-02-07 00:00:00"
  }
]
```

## 4. 按id获取活动详情

### 4.1 interface

`getActivityInfoById`

### 4.2 method

get/post

### 4.3 send

-   id

### 4.4 return

example

```json
{
  "id": "6",
  "name": "这是活动1",
  "summary": "没有活动简介",
  "info": "这是info",
  "photo": "/LoveInn/Public/Uploads/2017-02-07/5898a0249cb29.jpg",
  "begintime": "2017-02-07 09:00:00",
  "endtime": "2017-02-08 17:30:00",
  "location": "中国海洋大学",
  "categoryid": "1",
  "contact": "124124",
  "agencyid": "4",
  "capacity": "12",
  "isend": "0"
}
```

## 5. 获取志愿者头像

### 5.1 interface

`getAvatar`

### 5.2 method

get/post

### 5.3 send

-   id: 用户id

### 5.4 return

图片地址

形如: `/LoveInn/Public/Uploads/2017-02-04/5895f417cca84.jpg`

## 6. 获取学生证头像

### 6.1 interface

`getStucard`

其余同5.获取志愿者头像

## 7. 获取志愿者个人信息

### 7.1 interface

`getVolunteerInfo`

### 7.2 method

get/post

### 7.3 send

-   id: 用户id

### 7.4 return

example

```json
{
  "id": "1",
  "username": "222",
  "password": "bcbe3365e6ac95ea2c0343a2395834dd",
  "avatar": "/LoveInn/Public/Uploads/2017-02-04/5895f417cca84.jpg",
  "realname": "你好",
  "age": null,
  "sex": null,
  "idcard": null,
  "phone": null,
  "email": null,
  "info": null,
  "stucard": null,
  "money": "0",
  "ispass": "0"
}
```

## 8. 上传志愿者头像和学生证

### 8.1 interface

`uploadAvatar`

`uploadStucard`

### 8.2 method

post

### 8.3 send

id: userid

发送文件

avatar: `key` 为 `avatar`

stucard: `key`为`stucard`

### 8.4 return

-   0: 修改失败
-   1: 成功
-   2: 图片上传失败

## 9. 修改志愿者个人信息(实名认证)

### 9.1 interface

`updateRealname`

`updateSex`

下同....

### 9.2 method

post

### 9.3 send

-   id
-   realname / sex / age / idcard / phone / email / info

### 9.4 return

-   0: 失败
-   1: 成功


## 10. 获取实名认证状态

### 10.1 interface

`getAuthState`

### 10.2 method

get/post

### 10.3 send

-   id: 用户id

### 10.4 return

-   -1: 审核未通过
-   0: 等待审核
-   1: 审核通过

## 11. 报名公益活动

>   注: 需在app端判断实名认证状态, 未成功实名认证者不可报名参加活动

### 11.1 interface

`apply`

### 11.2 method

get/post

### 11.3 send

-   user_id: 用户id
-   activity_id: 活动id

### 11.4 return

-   -1: 已经报过名了(存在报名审核成功和等待审核两种情况)
-   0: 报名失败
-   1: 报名成功(存在第一次报名和曾报名但审核拒绝两种情况)


## 12. 实名认证

### 12.1 interface

`auth`

### 12.2 method

post

### 12.3 send

id: useid

### 12.4 return

-   -1: 失败
-   0: 已申请, 请等待
-   1: 成功, 等待审核

## 13. 历史活动信息

### 13.1 interface

`historyInfo`

### 13.2 method

post

### 13.3 send

id: userId

### 13.4 return

example

```json
[
  {
    "id": "5",
    "time": "2017-02-09 17:10:42",
    "rate": "1.0",
    "isjoin": "1",
    "name": "活动3"
  },
  {
    "id": "2",
    "time": "2017-02-09 17:09:39",
    "rate": "3.0",
    "isjoin": "1",
    "name": "测试活动"
  }
]
```

## 14. 兑换的礼品信息

### 14.1 interface
`exchangeInfo`

### 14.2 method

get

### 14.3 return

example

```json
[
  {
    "id": "1",
    "exname": "精致小台灯",
    "exmoney": "10"
  },
  {
    "id": "2",
    "exname": "手机卡扣",
    "exmoney": "16"
  }
]
```

## 15. 申请礼品兑换

### 15.1 interface

`exchangeApply`

### 15.2 method

post

### 15.3 send

user_id: user's id

ex_id: exchange item's id

set_money: volunteer's current money minus exchange item's money, that is left money of volunteer

### 15.4 return

1: successful

0: failed


## 16. 获取爱心币

### 16.1 interface

`getMoney`

### 16.2 method

post

### 16.3 send

user_id: user's id

### 16.4 return

money
