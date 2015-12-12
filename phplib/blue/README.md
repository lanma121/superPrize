# 云笔PHP业务层框架 Blue

适用于云笔业务层面的框架，依托于PDP存在，提供了一种Controller+Action+Service+Dao+View的基础框架，封装了通用的请求、返回流程。

该框架基于Yaf，在Yaf的基础上实现常见的流程、模式。

## 框架安装

1. 复制本代码到你的yaf全局phplib目录下即可

## 依赖配置

1. smarty.yaml 如果使用了VIEW_SMARY2，则需要此配置，此配置描述了smarty调用的模板位置
2. db.yaml 如果使用了mysql，则需要此配置
3. APP自身配置 blue.yaml(.ini 目前使用ini，未来使用yaml），描述了基础的Passport、Log配置等

## 维护团队

云笔PHP技术小组，[tech@yunbix.com](mailto:tech@yunbix.com)

如果有疑问，可以直接在讨论区里进行讨论。