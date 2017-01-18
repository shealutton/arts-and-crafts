corr <- function(directory, threshold = 0) {  
  ## Return a numeric vector of correlations
  id = 1:332
  answer <- vector()
  #directory <- "./specdata"
  for (i in id) {
    newID <- as.character(i) # force to character
    if ( nchar(newID[1]) == 1 ) { # add leading 00's if needed and .csv
      zz <- "00"
      name <- paste(zz,newID,".csv",sep='')
    } else if ( nchar(newID[1]) == 2 ) {
      z <- "0"
      name <- paste(z,newID,".csv",sep='')
    } else if ( nchar(newID[1]) == 3 ) {
      name <- paste(newID,".csv",sep='')
    } else {
      print("bad file name")
    }
  
    classes <- c("factor", "numeric", "numeric", "integer")
    filePath <- paste(directory,name,sep='/')
    data <- read.csv(file = filePath, colClasses = classes) # read data file    
    good <- complete.cases(data$sulfate, data$nitrate)

    if ( sum(complete.cases(data$sulfate, data$nitrate)) >= threshold ) {
      answer <- append(answer, cor(data$sulfate[good], data$nitrate[good]))
    } else {
      next
    }
    cor(data$sulfate[good], data$nitrate[good])
  }
  return(answer)
}