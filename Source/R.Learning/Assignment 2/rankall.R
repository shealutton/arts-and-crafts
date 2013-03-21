rankall <- function(outcome, num = 1) {  
  #getwd()
  #setwd("/Users/shea/Dropbox/R.Learning/Assignment 2")
  source("rankhospital.R")
  outcome <- "heart failure"
  num <- 4
  data <- read.csv("outcome-of-care-measures.csv", colClasses = "character")
  f <- suppressWarnings(as.factor(data[,7]))  
  success <- FALSE
  
  states <- as.list(c("AK", "AL", "AR", "AZ", "CA", "CO", "CT", "DC", "DE", "FL", "GA")) 
  #                    "GU", "HI", "IA", "ID", "IL", "IN", "KS", "KY", "LA", "MA", "MD", 
  #                    "ME", "MI", "MN", "MO", "MS", "MT", "NC", "ND", "NE", "NH", "NJ", 
  #                    "NM", "NV", "NY", "OH", "OK", "OR", "PA", "PR", "RI", "SC", "SD", 
  #                    "TN", "TX", "UT", "VA", "VI", "VT", "WA", "WI", "WV", "WY"))
  
  if ( outcome == "heart attack" ) {
    ok <- 1
  } else if (outcome == "heart failure") {
    #death <- suppressWarnings(as.numeric(data[,17]))
    ok <- 1
  } else if (outcome == "pneumonia") {
    #death <- suppressWarnings(as.numeric(data[,23]))
    ok <- 1
  } else {
    stop("invalid outcome")
  }

  answer <- matrix(nrow=1, ncol=2)
  for ( s in states ) {
    answer <- rbind(answer, c("hospital"=rankhospital(s, outcome, num), "state"=s), deparse.level=0)
  }
  final <- droplevels(na.fail(data.frame(answer)),reorder = TRUE)
  new <- data.frame(final)
  new
  return(final)
}
