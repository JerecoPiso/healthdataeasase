export const calculateEDC = (edcDate) => {
    const date = new Date(edcDate)
    // // for AOG
    // const currentDate = new Date();
    // const differenceMs = currentDate - date;
    // const weeks = Math.floor(differenceMs / (1000 * 60 * 60 * 24 * 7));
    // const remainingDaysMs = differenceMs % (1000 * 60 * 60 * 24 * 7);
    // const days = Math.floor(remainingDaysMs / (1000 * 60 * 60 * 24));
    // const aog = `${weeks} ${days}/7`

    // FOR EDC
    date.setDate(date.getDate() + 40 * 7)
    const edc = `${date.getFullYear()}-${date.getMonth() < 10 ? '0' + (date.getMonth() + 1) : (date.getMonth() + 1)}-${date.getDate() < 10 ? '0' + date.getDate() : date.getDate()}`
    return edc
}
export const calculateBMI = () => {

}