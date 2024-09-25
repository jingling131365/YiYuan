<?php
// +----------------------------------------------------------------------
// | 文件: app.php  
// +----------------------------------------------------------------------
// | 功能: 路由配置                                   
// +----------------------------------------------------------------------
// | 时间: 2024-09-25
// +----------------------------------------------------------------------
// | 作者: chengnn
// +----------------------------------------------------------------------
use think\facade\Route;

// 获取当前计数
Route::get('/api/count', 'index/getCount');

// 更新计数，自增或者清零
Route::post('/api/count', 'index/updateCount');
// // 获取用户信息
Route::post('/api/getOpenId', 'user/getOpenId');
