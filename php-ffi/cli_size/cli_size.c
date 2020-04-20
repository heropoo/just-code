/**
 * 通过函数 ioctl(); 获得终端界面的参数
 * @see https://blog.csdn.net/weixin_42205987/article/details/82080615
 */

//具体实现方法
#include <stdio.h>
#include <sys/ioctl.h>
#include <unistd.h>

unsigned short get_cli_rows()
{
    //定义winsize 结构体变量
    struct winsize size;
    //TIOCSWINSZ命令可以将此结构的新值存放到内核中
    ioctl(STDIN_FILENO, TIOCGWINSZ, &size);
    // printf("%d\n", size.ws_col);
    // printf("%d\n", size.ws_row);
    // return 0;
    return size.ws_row;
}

unsigned short get_cli_cols()
{
    //定义winsize 结构体变量
    struct winsize size;
    //TIOCSWINSZ命令可以将此结构的新值存放到内核中
    ioctl(STDIN_FILENO, TIOCGWINSZ, &size);
    // printf("%d\n", size.ws_col);
    // printf("%d\n", size.ws_row);
    // return 0;
    return size.ws_col;
}

struct winsize get_size()
{
    //定义winsize 结构体变量
    struct winsize size;
    //TIOCSWINSZ命令可以将此结构的新值存放到内核中
    ioctl(STDIN_FILENO, TIOCGWINSZ, &size);
    return size;
}