<?php
include '../db.php';

$limit = 5;
$page = isset($_POST['page']) ? (int) $_POST['page'] : 1;
$offset = ($page - 1) * $limit;
$query = isset($_POST['query']) ? trim($_POST['query']) : '';

// Build search condition
$search_condition = "";
if (!empty($query)) {
    $search = mysqli_real_escape_string($con, $query);
    $search_condition = "WHERE title LIKE '%$search%' OR category LIKE '%$search%' OR description LIKE '%$search%'";
}

// Count total
$total_result = mysqli_query($con, "SELECT COUNT(*) as total FROM courses $search_condition");
$total_row = mysqli_fetch_assoc($total_result);
$total_courses = $total_row['total'];
$total_pages = ceil($total_courses / $limit);

// Fetch filtered courses
$sql = "SELECT * FROM courses $search_condition ORDER BY id DESC LIMIT $offset, $limit";
$courses = mysqli_query($con, $sql);

$output = '';
if (mysqli_num_rows($courses) > 0) {
    while ($course = mysqli_fetch_assoc($courses)) {
        $output .= '<tr>
            <td>' . $course['id'] . '</td>
            <td>' . htmlspecialchars($course['category']) . '</td>
            <td>' . htmlspecialchars($course['title']) . '</td>
            <td>' . nl2br(htmlspecialchars($course['description'])) . '</td>
            <td>' . htmlspecialchars($course['duration']) . '</td>
            <td>' . number_format($course['price'], 2) . '</td>
            <td>' . htmlspecialchars($course['material_url']) . '</td>
            <td>' . (!empty($course['start_date']) ? date("d-M-Y", strtotime($course['start_date'])) : '—') . '</td>
            <td>' . (!empty($course['end_date']) ? date("d-M-Y", strtotime($course['end_date'])) : '—') . '</td>
            <td>';
        if (!empty($course['image'])) {
            $output .= '<img src="image/' . htmlspecialchars($course['image']) . '" width="100" height="100">';
        } else {
            $output .= 'No Image';
        }
        $output .= '</td>
            <td>
                <div class="dropdown">
                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                        <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="addCourses.php?u_id=' . $course['id'] . '">
                            <i class="bx bx-edit-alt me-1"></i> Edit</a>
                        <a class="dropdown-item" href="viewCourses.php?d_id=' . $course['id'] . '" onclick="return confirm(\'Are you sure you want to delete this course?\');">
                            <i class="bx bx-trash me-1"></i> Delete</a>
                    </div>
                </div>
            </td>
        </tr>';
    }
} else {
    $output .= '<tr><td colspan="11" class="text-center">No courses found</td></tr>';
}

// Pagination buttons
$pagination = '<nav aria-label="Page navigation"><ul class="pagination justify-content-center">';
for ($i = 1; $i <= $total_pages; $i++) {
    $active = ($i == $page) ? 'active' : '';
    $pagination .= '<li class="page-item ' . $active . '">
                      <a class="page-link" href="#" data-page="' . $i . '">' . $i . '</a>
                    </li>';
}
$pagination .= '</ul></nav>';

echo json_encode(['table' => $output, 'pagination' => $pagination]);
?>