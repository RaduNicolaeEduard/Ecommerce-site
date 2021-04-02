export type User = {name: string; username:string}
export type UserList = Array<User & {password:string}>


export async function login(){}
export async function getUser() {
}