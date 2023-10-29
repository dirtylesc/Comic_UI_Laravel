export const ONGOING    = 0;
export const COMPLETED  = 1;
export const UNRELEASED = 2;
export const DEFERED    = 3;
export const PENDING    = 4;

export const reqStatusObj = (n) => {
    const status = {
        value: "",
        title: "",
    }
    
    switch (n) {
        case ONGOING:
            status.value =  ONGOING;
            status.title =  "Ongoing";
            break;
        case COMPLETED: 
            status.value =  COMPLETED;
            status.title =  "Completed";
            break;
        case UNRELEASED: 
            status.value =  UNRELEASED;
            status.title =  "Unreleased";
            break;
        case DEFERED: 
            status.value =  DEFERED;
            status.title =  "Defered";
            break;
        case PENDING: 
            status.value =  PENDING;
            status.title =  "Pending";
            break;
        default:
            break;
    }

    return status;
}

export const reqArrStatus = () => {
    return {
        [ONGOING]    : "Ongoing",
        [COMPLETED]  : "Completed",
        [UNRELEASED] : "Unreleased",
        [DEFERED]    : "Defered",
        [PENDING]    : "Pending",
    }
}

export const reqStatusClass = (n) => {
    switch (n) {
        case ONGOING:
            return "badge-info";
        case COMPLETED: 
            return "badge-success";
        case UNRELEASED: 
            return "badge-secondary";
        case DEFERED: 
            return "badge-warning";
        case PENDING: 
            return "badge-warning";
        default:
            break;
    }
}