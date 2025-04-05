<?php
require_once '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $groupName = $_POST['group_name'] ?? '';
    $fonts = $_POST['fonts'] ?? [];
    $groupId = $_POST['group_id'] ?? null;

    if (count(array_filter($fonts)) < 2) {
        echo json_encode(['success' => false, 'message' => 'Select at least 2 fonts.']);
        exit;
    }

    $pdo = Database::connect();

    if ($groupId) {
        // Update existing group
        $stmt = $pdo->prepare("UPDATE font_groups SET group_name = ? WHERE id = ?");
        $stmt->execute([$groupName, $groupId]);

        $stmt = $pdo->prepare("DELETE FROM font_group_items WHERE group_id = ?");
        $stmt->execute([$groupId]);

        $stmt = $pdo->prepare("INSERT INTO font_group_items (group_id, font_id) VALUES (?, ?)");
        foreach ($fonts as $fontId) {
            if(!empty($fontId)){
                $stmt->execute([$groupId, $fontId]);
            }
        }

        echo json_encode(['success' => true, 'message' => 'Group updated.']);
    } else {
        // Create new group
        $stmt = $pdo->prepare("INSERT INTO font_groups (group_name) VALUES (?)");
        $stmt->execute([$groupName]);
        $newGroupId = $pdo->lastInsertId();

        $stmt = $pdo->prepare("INSERT INTO font_group_items (group_id, font_id) VALUES (?, ?)");
        foreach ($fonts as $fontId) {
            if(!empty($fontId)){
               $stmt->execute([$newGroupId, $fontId]); 
            }
        }

        echo json_encode(['success' => true, 'message' => 'Group created.']);
    }
}
