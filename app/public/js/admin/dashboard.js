document.addEventListener("DOMContentLoaded", function () {
  // Lấy thông tin đơn hàng pending từ API
  function loadPendingOrders() {
    fetch("/WebbandoTT/app/api/orders/get_pending_orders.php")
      .then((response) => response.json())
      .then((data) => {
        console.log("Dữ liệu đơn hàng pending:", data); // Debug log
        if (data.success) {
          const orders = data.data;
          const ordersTableBody = document.querySelector("tbody");

          // Xóa dữ liệu cũ trong bảng
          ordersTableBody.innerHTML = "";

          // Thêm các đơn hàng mới vào bảng
          orders.forEach((order) => {
            const tr = document.createElement("tr");
            tr.setAttribute("data-order-id", order.id); // Thêm thuộc tính này

            tr.innerHTML = `
              <td>${order.id}</td>
              <td>${order.ho_ten}</td>
              <td>${new Intl.NumberFormat().format(order.tong_tien)}₫</td>
              <td><span class="badge bg-warning">${order.trang_thai}</span></td>
              <td><button class="btn btn-success btn-sm" onclick="updateOrderStatus(${
                order.id
              }, '${order.trang_thai}')">Xác nhận</button></td>
            `;
            ordersTableBody.appendChild(tr);
          });
        } else {
          Swal.fire(
            "Lỗi!",
            data.message || "Không thể lấy thông tin đơn hàng.",
            "error"
          );
        }
      })
      .catch((error) => {
        console.error("Lỗi khi tải đơn hàng:", error);
        Swal.fire("Lỗi!", "Có lỗi xảy ra khi lấy thông tin đơn hàng.", "error");
      });
  }

  // Gọi hàm để tải đơn hàng ngay khi trang được tải
  loadPendingOrders();

  // Xử lý sự kiện làm mới thông tin
  document
    .getElementById("refreshStats")
    ?.addEventListener("click", function () {
      loadPendingOrders();
    });
});

function updateOrderStatus(orderId, currentStatus) {
  // Hiển thị hộp thoại xác nhận
  Swal.fire({
    title: "Xác nhận cập nhật trạng thái?",
    text: `Bạn có chắc chắn muốn cập nhật trạng thái đơn hàng (Order ID: ${orderId}) từ "${currentStatus}"?`,
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Có, cập nhật!",
    cancelButtonText: "Hủy",
  }).then((result) => {
    if (result.isConfirmed) {
      // Nếu người dùng xác nhận, thực hiện cập nhật trạng thái
      fetch("/WebbandoTT/app/api/orders/update_order_status.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: `order_id=${orderId}&current_status=${currentStatus}`,
      })
        .then((response) => response.json())
        .then((data) => {
          console.log("Cập nhật trạng thái đơn hàng: ", data); // Debug log
          if (data.success) {
            Swal.fire("Thành công", data.message, "success").then(() => {
              // Tìm dòng tương ứng trong bảng và cập nhật trạng thái
              const row = document.querySelector(
                `tr[data-order-id="${orderId}"]`
              );
              if (row) {
                const statusCell = row.querySelector("td:nth-child(4)");
                const statusBadge = statusCell.querySelector(".badge");
                statusBadge.textContent = currentStatus;
                statusBadge.className = `badge bg-${getBadgeClass(
                  currentStatus
                )}`; // Cập nhật lớp CSS của badge
              }
            });
            location.reload();
          } else {
            // Hiển thị thông báo lỗi với orderId và currentStatus
            Swal.fire(
              "Lỗi!",
              `${
                data.message || "Không thể cập nhật trạng thái đơn hàng."
              } (Order ID: ${orderId}, Current Status: ${currentStatus})`,
              "error"
            );
          }
        })
        .catch((error) => {
          console.error("Lỗi:", error);
          // Hiển thị thông báo lỗi với orderId và currentStatus
          Swal.fire(
            "Lỗi!",
            `Có lỗi xảy ra khi cập nhật trạng thái đơn hàng (Order ID: ${orderId}, Current Status: ${currentStatus})`,
            "error"
          );
        });
    }
  });
}
// Hàm này trả về lớp CSS phù hợp cho badge theo trạng thái
function getBadgeClass(status) {
  switch (status) {
    case "pending":
      return "warning";
    case "processing":
      return "info";
    case "shipped":
      return "primary";
    case "completed":
      return "success";
    case "cancelled":
      return "danger";
    default:
      return "secondary";
  }
}
