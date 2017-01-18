getmonitor <- function(id, directory, summarize = FALSE) {
  # force to character
  tempID <- as.character(id)
  #strip .csv if exists
  newID <- strsplit(tempID, ".csv")

  # add leading 00's if needed and .csv
  if ( nchar(newID[1]) == 1 ) {
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
  
  test <- summarize
  if (test == TRUE) {
    #summary(data)
    print(summary(data))
    return(data)
  } else {
    return(data)
  }
}