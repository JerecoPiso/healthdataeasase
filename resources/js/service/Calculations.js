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
export const calculateBMI = (weightInKG, heightInCM) => {
    let heightInMeters = heightInCM / 100;
    // Calculate BMI using the formula
    return (weightInKG / (heightInMeters * heightInMeters)).toFixed(2);
}


export const calculateAge = (bdate) => {

    const birthdate = new Date(bdate);
    const currentDate = new Date();
    const diffInMilliseconds = currentDate - birthdate;
    // return Math.floor(diff / (1000 * 60 * 60 * 24 * 365.25));
    const ageInYears = Math.floor(diffInMilliseconds / (1000 * 60 * 60 * 24 * 365.25));

    if (ageInYears >= 1) {
        return ageInYears + ' year/s old' + ` (${calculateMonthsAfterBirthdate(bdate)})`;
    } else {
        const birthYear = birthdate.getFullYear();
        const birthMonth = birthdate.getMonth();
        const birthDay = birthdate.getDate();
        const currentYear = currentDate.getFullYear();
        const currentMonth = currentDate.getMonth();
        const currentDay = currentDate.getDate();
        let ageInMonths = (currentYear - birthYear) * 12 + (currentMonth - birthMonth);
        let ageInString = ''
        // If age in months is 0, calculate the days difference
        if (ageInMonths === 0) {
            const diffInDays = Math.floor(diffInMilliseconds / (1000 * 60 * 60 * 24));
            ageInString = diffInDays + ' day/s old';
        } else {
            // Adjust the month count if the current day is before the birth day
            if (currentDay < birthDay) {
                ageInMonths -= 1;
                // If age in months becomes 0 after adjustment, calculate the days difference
                if (ageInMonths === 0) {
                    const diffInDays = Math.floor(diffInMilliseconds / (1000 * 60 * 60 * 24));
                    ageInString = diffInDays + ' day/s old';
                }
            }
            ageInString = ageInMonths + ' month/s old';
        }
        return ageInString + ` (${calculateMonthsAfterBirthdate(bdate)})`
    }
}

export const calculateMonthsAfterBirthdate = (birthdate) => {
    // Convert the strings to Date objects
    let birthDate = new Date(birthdate);
    let current = new Date();

    // Calculate the difference in years and months
    let yearsDifference = current.getFullYear() - birthDate.getFullYear();
    let monthsDifference = current.getMonth() - birthDate.getMonth();

    // Calculate the total months
    let totalMonths = yearsDifference * 12 + monthsDifference;

    // Ensure we do not count a partial month if the day of the current date is before the birth date day
    if (current.getDate() < birthDate.getDate()) {
        totalMonths--;
    }
    let ageCategory = ''
    if(totalMonths <= 3){
        ageCategory = 'Newborn'
    }else if(totalMonths > 3 && totalMonths <= 12){
        ageCategory = 'Infants'
    }else if(totalMonths > 12 && totalMonths <= 60){
        ageCategory = 'Toddler'
    }else if(totalMonths > 61 && totalMonths <= 84){
        ageCategory = 'Kids'
    }else if(totalMonths > 84){
        ageCategory = 'Adults'
    }
    return `${totalMonths} months ${ageCategory}`;
}
