## 爱心驿站数据库文档

### 迭代记录

| 版本   | 时间         | 说明                                    | 修改者     |
| ---- | ---------- | ------------------------------------- | ------- |
| v1.0 | 2016.02.02 | 建表                                    | waydrow |
| v1.1 | 2016.02.03 | 修改apply表中time类型                       | waydrow |
| v1.2 | 2016.02.03 | 添加admin表                              | waydrow |
| v1.3 | 2016.02.05 | 在apply表中添加isjoin字段                    | waydrow |
| v1.4 | 2016.02.05 | 修改volunteer和agency表, ispass字段默认为-1    | waydrow |
| v1.5 | 2016.02.06 | activity表中添加photo字段                   | waydrow |
| v1.6 | 2017.04.27 | 新增 exchange / exapply 表, 爱心币兑换礼品, 申请表 | waydrow |

### volunteer (志愿者表)

| 字段       | 类型      | 说明               | 默认值      |
| -------- | ------- | ---------------- | -------- |
| id       | int     | 标识               |          |
| username | varchar | 用户名(默认为学号)       |          |
| password | varchar | 密码(md5)          |          |
| avatar   | varchar | 个人头像             |          |
| realname | varchar | 真实姓名             |          |
| age      | int     | 年龄               |          |
| sex      | varchar | 性别(m/f)          |          |
| idcard   | varchar | 身份证              |          |
| phone    | varchar | 电话               |          |
| email    | varchar | 电子邮箱             |          |
| info     | varchar | 个人简介             |          |
| stucard  | varchar | 学生证照片(审核使用)      |          |
| money    | int     | 爱心币(活动评分/2取整 累加) | 0        |
| ispass   | int     | 注册审核(-1/0/1)     | -1默认审核失败 |

### activity (公益活动表)

| 字段         | 类型       | 说明         | 默认值    |
| ---------- | -------- | ---------- | ------ |
| id         | int      | 标识         |        |
| name       | varchar  | 活动名称       |        |
| summary    | varchar  | 简介         |        |
| info       | varchar  | 详细介绍       |        |
| photo      | varchar  | 活动图片       |        |
| begintime  | datetime | 活动开始时间     |        |
| endtime    | datetime | 活动结束时间     |        |
| location   | varchar  | 活动地址       |        |
| categoryid | int      | 活动种类(外键)   |        |
| contact    | varchar  | 联系电话       |        |
| agencyid   | int      | 公益机构(外键)   |        |
| capacity   | int      | 最大报名人数     |        |
| isend      | int      | 活动结束(0/1)  | 0(未结束) |
| israte     | int      | 是否已评分(0/1) | 0未评分   |

### category (活动种类表)

| 字段   | 类型      | 说明   | 默认值  |
| ---- | ------- | ---- | ---- |
| id   | int     | 标识   |      |
| name | varchar | 种类名  |      |

### agency (公益机构表)

| 字段            | 类型      | 说明           | 默认值        |
| ------------- | ------- | :----------- | ---------- |
| id            | int     | 标识           |            |
| username      | varchar | 用户名          |            |
| password      | varchar | 密码           |            |
| name          | varchar | 机构名          |            |
| photo         | varchar | 机构图片         |            |
| address       | varchar | 地址           |            |
| contact       | varchar | 联系方式         |            |
| certification | varchar | 审核材料(营业执照等)  |            |
| ispass        | int     | 注册审核(-1/0/1) | -1(默认审核失败) |

### apply (报名表)

| 字段         | 类型           | 说明                | 默认值               |
| ---------- | ------------ | ----------------- | ----------------- |
| id         | int          | 标识                |                   |
| userid     | int          | 志愿者id(外键)         |                   |
| activityid | int          | 活动id(外键)          |                   |
| time       | timestamp(4) | 报名时间              | CURRENT_TIMESTAMP |
| rate       | decimal(2,1) | 组织者对志愿者的评分(10分满分) |                   |
| isjoin     | int          | 审核是否通过(-1/0/1)    | 0                 |

### admin (管理员表)

| 字段       | 类型      | 说明   | 默认值  |
| -------- | ------- | ---- | ---- |
| id       | int     | 标识   |      |
| account  | varchar | 帐号   |      |
| password | varchar | 密码   |      |
| name     | varchar | 昵称   |      |

### exchange (兑换礼品表)

| 字段      | 类型      | 说明      | 默认值  |
| ------- | ------- | ------- | ---- |
| id      | int     | 标识      |      |
| exname  | varchar | 礼品名字    |      |
| exmoney | varchar | 礼品所需爱心币 |      |

### exapply (兑换申请表)

| 字段     | 类型   | 说明     | 默认值     |
| ------ | ---- | ------ | ------- |
| id     | int  | 标识     |         |
| userid | int  | 申请人 id |         |
| exid   | int  | 礼品 id  |         |
| isend  | int  | 是否处理完毕 | 0 (未处理) |


### subscribe (用户订阅表)

| 字段     | 类型   | 说明     | 默认值     |
| ------ | ---- | ------ | ------- |
| id     | int  | 标识     |         |
| userid | int  | 用户 id |         |
| categoryid | int  | 种类 id  |         |