import moment from "moment";

export function timeApp(time) {
    return moment(time).fromNow()
}