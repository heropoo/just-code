#include <sapi/embed/php_embed.h>

int main(int argc, char **argv)
{
    zend_file_handle file_handle;
    
    // php 框架初始化
    php_embed_init(argc, argv);
    file_handle.type = ZEND_HANDLE_FILENAME;
    file_handle.filename = "console.php";

    // execute script
    php_execute_script(&file_handle);

    // 关闭php框架
    php_embed_shutdown(); 

    return 0;
}