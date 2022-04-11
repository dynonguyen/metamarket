<h1 align="center">MetaMarket Project</h1>

> Ứng dụng đi chợ Online - Đồ án môn Ứng dụng phân tán - Microservice Architecture

# Giới thiệu dự án

> **Mục tiêu**

Một công ty đầu tư thương mại ABC muốn xây dựng hệ thống kết nối giữa bên mua và bên bán các mặt hàng thiết yếu. Trong bối cảnh dịch bệnh diễn biến phức tạp, người dùng có nhu cầu mua các mặt hàng sản phẩm thiết yếu như thịt, cá, rau, củ,…. Những thực phẩm này được cung cấp bởi các nhà cung cấp uy tín trên thị trường.

Công ty ABC là bên đầu tư hệ thống phần mềm để quản lý các dịch vụ này, mục tiêu là cung cấp dịch vụ tốt nhất cho người mua và người bán, công ty muốn xây dựng và quản lý hệ thống cung cấp các dịch vụ như đăng kí bán hàng, đăng ký mua hàng, giao hàng, và các dịch vụ khác. Công ty sẽ thu phí dựa trên số lượng hóa đơn phát sinh, doanh thu chủ yếu công ty sẽ đến từ hoạt động chính này. Phấn tiếp theo sẽ mô tả các quy trình trong dự án.

> **Yêu cầu công nghệ**

PHP, HTML, JS, CSS dùng để xây dựng trang web với các chức năng cơ bản như: login, logout, thông tin liên hệ,…

Java framework (NodeJS ...) dùng để xây dựng API, trả dữ liệu về bên website, giao tiếp với API theo hướng đồng bộ. Các API cũng trao đổi message với nhau theo hướng bất đồng bộ phụ thuộc vào chức năng. Cần có API gateway để quản lý nhiều API khác trong trường hợp một chức năng gọi trên 3 API

# Thông tin nhóm

> **MetaMarket Team**

- 18120580 - Đinh Quang Thọ
- 18120606 - Trần Thị Trang
- 18120609 - Hồ Khắc Minh Trí
- 18120634 - Nguyễn Lê Anh Tuấn (Nhóm trưởng)

# Công nghệ phát triển

> **Client Side**

- HTML, CSS, JS
- JQuery v3.6.0
- Bootstrap 5

> **Backend Server**

- PHP thuần
- Apache Server
- MVC Model

> **API Server**

- Kiến trúc Microservices
- [Moleculer Framework](https://moleculer.services/docs/0.14/index.html) v0.14.16 (NodeJS)
- MongoDB, MongooseJS

> **Development Tools**

- VSCode Editor
- Git, Github
- Slack

> **Deyloying**

- Docker
- Transporter - NATS Server

# Kiến trúc hệ thống

**Use Case Diagram**

![UC-Diagram](https://res.cloudinary.com/dynonary/image/upload/v1649652591/metamarket/UC-Diagram.png)
