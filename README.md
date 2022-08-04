# kuafu_go（夸父出行）

## 背景
聚合各种国内现行网约车平台

## 目前支持网约车网关
| 名称 | 网关名称 |
| :--- | :---- |
| Ruqi_GO | 如祺 |
| T3_GO | T3 |

## 网约车网关目前支持以下方法
- createOrder(array $params)  
说明：创建订单接口  

- getValuation(array $params)  
说明：获取估价接口  

- getOrder(array $params)  
说明：获取订单详情接口  

- getOrderList(array $params)  
说明：获取订单列表接口

- getDriverLocation(array $params)  
说明：取消订单接口

- getDriverLocation(array $params)  
说明：获取司机实时位置接口

- saveOrderScore(array $params)  
说明：司机评分接口

## 目前支持网约车后台网关
| 名称 | 网关名称 |
| :--- | :---- |
| DidiEs_Admin | 滴滴企业版 |

## 网约车网关目前支持以下方法
- getAccessToken()  
说明：获取凭证  

- LoginEs(array $params)  
说明：登录后台  

- LoginClient(array $params)  
说明：登录客户端  

