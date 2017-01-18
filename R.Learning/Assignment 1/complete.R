complete <- function(directory, id = 1:332) {  
  vid <- vector()
  vcc <- vector()

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
    
    filePath <- paste(directory,name,sep='/')
    data <- read.csv(file = filePath) # read data file
    vid <- append(vid, i)
    vcc <- append(vcc, sum(complete.cases(data)))
  }
  df <- data.frame(vid, vcc)
  names(df) <- c("id", "nobs")
  return(df)
}