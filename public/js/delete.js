function delete_alert() {

    var checked = confirm("本当に削除しますか？");
    
    if (checked == true) {
        return true;
    } else {
        window.alert('キャンセルされました'); 
        return false;
    }
};