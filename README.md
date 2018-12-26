# php-fmt

`php` 代码格式化工具，
基于 [php-parser 4,x](https://github.com/nikic/PHP-Parser)，
可以批量快速美化代码

目前只支持 `php7.0` 以上版本

# 安装

- 本地确保已经安装 [composer](https://www.phpcomposer.com/)，
推荐使用 [中国镜像](https://pkg.phpcomposer.com/)
- 可以在任意目录下执行命令 `composer global require jackdou/php-fmt`
- 确保 `composer` 下的 `vendor/bin` 目录已经添加到系统环境变量
- 在任意目录执行 `php-fmt` 命令，可以执行则安装成功

# 使用

- 进入需要美化的代码目录
- 执行命令 `php-fmt` 会自动美化所有 `php` 的脚本文件
- 如只想美化指定文件，执行 `php-fmt yourfilename.php` 即可

# 说明

- `php-fmt` 使用了缓存功能，当一个文件在上一次美化后没有任何修改记录则执行命令后会自动跳过，
加快命令执行速度
- 感谢 `php-parser`
- 有任何方面的问题可以提交 `issues`，感谢


