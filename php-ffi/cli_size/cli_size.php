<?php

// $res = exec("./a.out", $output, $return_var);
// var_dump($res, $output, $return_var);

// gcc -c -fPIC -o cli_size.o cli_size.c
// gcc -shared -o libcli_size.so cli_size.o
// or gcc -O2 -fPIC -shared -g cli_size.c -o libcli_size.so

$ffi = FFI::cdef(<<<CTYPE
struct winsize {
	unsigned short  ws_row;         /* rows, in characters */
	unsigned short  ws_col;         /* columns, in characters */
	unsigned short  ws_xpixel;      /* horizontal size, pixels */
	unsigned short  ws_ypixel;      /* vertical size, pixels */
};
unsigned short get_cli_rows(); 
unsigned short get_cli_cols(); 
struct winsize get_size();
CTYPE, 'libcli_size.so');
//var_dump($ffi);
var_dump($ffi->get_cli_rows());
var_dump($ffi->get_cli_cols());
var_dump($ffi->get_size());
var_dump($ffi->get_size()->ws_row);
