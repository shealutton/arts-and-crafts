rankhospital <- function(state, outcome, num = 1) {  
  #state <- "TX"
  #outcome <- "heart failure"
  #num <- 4
  data <- read.csv("outcome-of-care-measures.csv", colClasses = "character")
  f <- suppressWarnings(as.factor(data[,7]))  
  success <- FALSE
  
  if ( outcome == "heart attack" ) {
    death <- suppressWarnings(as.numeric(data[,11]))
  } else if (outcome == "heart failure") {
    death <- suppressWarnings(as.numeric(data[,17]))
  } else if (outcome == "pneumonia") {
    death <- suppressWarnings(as.numeric(data[,23]))
  } else {
    stop("invalid outcome")
  }
  
  for (i in levels(f)) {
    if ( i == state ) {
      success <- TRUE
      break
    }
  }
  if ( success == FALSE ) {
    stop("invalid state")
  }

  temp <- data.frame(death, ST = c(data[,7]), name = c(data[,2]))
  final <- droplevels(na.omit(data.frame(subset(temp, ST == state, drop = TRUE))), reorder = TRUE)
  new <- final[ order(final$death, final$name, final$ST) ,]
  
  if ( num == "best") {
    num = 1
  } else if ( num == "worst" ) {
    num = length(new$name)
  } else if ( num >= length(new$name) ) {
    return("NA")
  }
  answer <- as.character(new$name[num])
  
  return(answer)
}



