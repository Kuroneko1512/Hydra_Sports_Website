# Mô tả cấu trúc thư mục

## Lưu ý:
* Trang dành cho người dùng và trang dành cho admin được chia rõ ràng, được tách làm 2 thư mục độc lập.
* Cả người dùng và admin sẽ dùng chung các thành phần:

1. commons: Chứa các lớp chung của cả project

    * env.php        : Chứa cấu hình của hệ thống
    * core.php       : Nhiệm vụ khởi tạo hệ thống, load các thành phần của hệ thống
    * controller.php :  Chứa lớp cấu trúc mặc định của 1 controller sẽ phải kế thừa
    * model.php      : Chứa lớp cấu trúc mặc định của 1 model sẽ phải kế thừa
    * route.php      : Chứa lớp cấu trúc route
    * view.php       : Chứa lớp cấu trúc view

2. uploads: Toàn bộ tài nguyên upload sẽ được đẩy vào thư mục này

## Trang dành cho người dùng

Thư mục: clients

Cấu trúc gồm các thư mục chứa thành phần của controller, model, view

File router.php khai báo cấu trúc math giữa action và controller tương ứng

## Trang dành cho admin

Thư mục: admin

Cấu trúc gồm các thư mục chứa thành phần của  controller, model, view

File router.php khai báo cấu trúc math giữa action và controller tương ứng