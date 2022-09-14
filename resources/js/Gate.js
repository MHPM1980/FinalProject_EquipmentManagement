export default class Gate {

    constructor(user) {
        this.user = user;
    }

    isAdmin(){
        return this.user.role_id === 1;
    }
    isGestor(){
        return this.user.role_id === 2;
    }
    isFormador(){
        return this.user.role_id === 3;
    }
    isFormando(){
        return this.user.role_id === 4;
    }

}
