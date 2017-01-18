### ASSIGNMENT 2, PART 1
getwd()
setwd("/Users/shea/Dropbox/R.Learning/Assignment\ 2")
setwd("/home/shea/Dropbox/R.Learning/Assignment\ 2")
outcome <- read.csv("outcome-of-care-measures.csv", colClasses = "character")
head(outcome)
summary(outcome)
outcome[, 11] <- as.numeric(outcome[, 11])
hist(outcome[,11], xlab = "30-day Death Rate", main = "Heart Attack 30-day Death Rate")
hist

par(mfrow = c(3, 1)) 

splom(~ outcome)
histogram( ~ temperature, data = environmental)
histogram( ~ temperature | wind.cut, data = environmental)
histogram( ~ ozone | wind.cut, data = environmental)
histogram( ~ ozone | temp.cut * wind.cut, data = environmental)

# Identify which columns of the data frame contain the 
# 30-day death rate from heart attack, 
# 30-day death rate from heart failure,
# 30-day death rate from pneumonia.
# Col 17 = Hospital 30-Day Death (Mortality) Rates from Heart Failure: Lists the risk adjusted rate (percentage)
# Col 23 = Hospital 30-Day Death (Mortality) Rates from Pneumonia: Lists the risk adjusted rate (percentage)
# Col 11 = Hospital 30-Day Death (Mortality) Rates from Heart Attack: Lists the risk adjusted rate (percentage) 
# for each hospital. 

### ASSIGNMENT 2, PART 2
outcome[, 11] <- as.numeric(outcome[, 11])
outcome[, 17] <- as.numeric(outcome[, 17])
outcome[, 23] <- as.numeric(outcome[, 23])
median.ha <- median(outcome[,11], na.rm = TRUE)
median.hf <- median(outcome[,17], na.rm = TRUE)
median.pn <- median(outcome[,23], na.rm = TRUE)
title.ha <- substitute("30-day Death Rate (" * bar(X) == k * ")", list(k = round(mean(outcome[,11], na.rm = TRUE),2)))
title.hf <- substitute("30-day Death Rate (" * bar(X) == k * ")", list(k = round(mean(outcome[,17], na.rm = TRUE),2)))
title.pn <- substitute("30-day Death Rate (" * bar(X) == k * ")", list(k = round(mean(outcome[,23], na.rm = TRUE),2)))
ran = range(outcome[,11], outcome[,17], outcome[,23], na.rm = TRUE) # generates the offsetting graphs

# PICK 1 !
par(mfrow = c(1, 3))
par(mfrow = c(3, 1))
par(mfrow = c(1, 1))

# Must have prob = TRUE in order to print the density
hist(outcome[,11], main = "Heart Attack", xlim = ran, xlab = title.ha, prob=TRUE)
abline(v=median.ha, lmd = 3, col = "red")
lines(density(outcome[,11],na.rm=TRUE),col="sienna")

hist(outcome[,17], main = "Heart Failure", xlim = ran, xlab = title.hf, prob=TRUE)
abline(v=median.hf, lmd = 3, col = "red")
lines(density(outcome[,17],na.rm=TRUE),col="sienna")

hist(outcome[,23], main = "Pneumonia", xlim = ran, xlab = title.pn, prob=TRUE)
abline(v=median.pn, lmd = 3, col = "red")
lines(density(outcome[,23],na.rm=TRUE),col="sienna")


### ------------------------------------------------------------------------ ###
### ASSIGNMENT 2, PART 3
outcome <- read.csv("outcome-of-care-measures.csv", colClasses = "character")
outcome[, 11] <- as.numeric(outcome[, 11])
table(outcome$State)

# Remove states with < 20 samples with subset
temp <-table(outcome$State)
outcome2 <- subset(outcome, State %in% names(temp)[temp>=20])
#table(outcome2$State)
death <- outcome2[,11]
state <- outcome2[,7]
state

# set titles 90 deg rotated and smaller font
par(srt = 180, las = 2, cin = 0.01)
# boxplot of states by death rate. Get the deaths, and the states
title <- as.character("Heart Attack 30-day Death Rate by State")
boxplot(death ~ state, main = title, ylab = "30-day Death Rate")

# Order graph by median (SOMEONE ELSES METHOD)
death <- suppressWarnings(as.numeric(outcome[, 11]))
bymedian <- reorder(outcome$State, death, function(x) median(x, na.rm = TRUE))
boxplot(death ~ bymedian)

# Order graph by median (MY METHOD)
final <- na.omit(data.frame(state = c(outcome2[,7]), death = c(outcome2[,11])))
# REORDER: a method of sorting a vector based on a second vector of factors. 
# Can incorporate functions too. 
bymedian <- with(final, reorder(state, death, median))
boxplot(final$death ~ bymedian)

### ------------------------------------------------------------------------ ###
### ASSIGNMENT 2, PART 4
outcome <- read.csv("outcome-of-care-measures.csv", colClasses = "character")
hospital <- read.csv("hospital-data.csv", colClasses = "character")
# Merge datasets (like a join)
outcome.hospital <- merge(outcome, hospital, by = "Provider.Number")

death <- as.numeric(outcome.hospital[, 11]) ## Heart attack outcome
npatient <- as.numeric(outcome.hospital[, 15])
owner <- factor(outcome.hospital$Hospital.Ownership)

# call lib
library(lattice)
xyplot(death ~ npatient | owner, 
  xlab = "Number of Patients Seen", 
  ylab = "30-day Death Rate",
  main = "Heart Attack 30-day Death Rate by Ownership",
  panel = function(x, y, ...) {
    panel.xyplot(x,y, ...) # If you add a panel function, you need to replot
    panel.lmline(x, y) # Adds a regression line
  }
)

