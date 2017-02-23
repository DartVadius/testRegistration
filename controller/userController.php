<?php

/**
 * userController
 *
 * @author DartVadius
 */
class userController extends baseController {

    /**
     * redirect to registation
     */
    public function indexAction() {
        $terr = new territoryModel();
        $region = $terr->findRegion();
        $param = [
            ['user/registration', ['region' => $region]]
        ];
        $this->view->render($param);
    }

    /**
     * dropdown lists
     */
    public function regionAction() {
        $entityBody = file_get_contents('php://input');
        $data = json_decode($entityBody, TRUE);
        $terr = new territoryModel();
        $id = $data['id'];
        if ($id == 1) {
            $reg = $terr->findChillrenCity($data['val']);
        } else {
            $reg = $terr->findCityDistrict($data['val']);
        }
        if (!empty($reg)) {
            $id++;
            //знаю, что по уродски
            $list = "<select name=" . $id . " id=" . $id . " class='chosen'>";
            $list .= "<option value='0' selected>-----</option>";
            foreach ($reg as $region) {
                $list .= "<option value=" . $region['ter_id'] . ">" . $region['ter_name'] . "</option>";
            }
            $list .= "</select>";
            $answer = [
                'id' => $data['id'],
                'list' => $list,
            ];
            echo (json_encode($answer));
        } else {
            echo FALSE;
        }
    }

    /**
     * save user to DB
     */
    public function saveAction() {
        $entityBody = file_get_contents('php://input');
        $data = json_decode($entityBody, TRUE);
        $name = $data[0]['value'];
        $email = $data[1]['value'];
        $id = array_pop($data)['value'];
        $user = new userModel($name, $email, $id);
        $findEmail = $user->findByEmail();
        $terr = new territoryModel();
        $msg = NULL;
        if ($findEmail) {
            $address = $terr->findAddressById($user->getTerritory());
            $msg = 'Пользователь с таким email уже существует';
        } else {
            $user->save();
            $address = $terr->findAddressById($user->getTerritory());
        }
        $answer = [
            'name' => $name,
            'email' => $email,
            'address' => $address,
            'msg' => $msg,
        ];
        echo (json_encode($answer));
    }

}
